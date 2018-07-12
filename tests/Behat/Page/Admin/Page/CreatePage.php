<?php

/*
 * This file has been feated by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Page;

use Behat\Mink\Driver\Selenium2Driver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\WysiwygHelper;
use Sylius\Behat\Service\SlugGenerationHelper;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function uploadImage(string $image): void
    {
        $path = __DIR__ . '/../../../Resources/images/' . $image;

        Assert::fileExists($path);

        $this->getDocument()->attachFileToField('Choose file', realpath($path));
    }

    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);

        if ($this->getDriver() instanceof Selenium2Driver) {
            SlugGenerationHelper::waitForSlugGeneration($this->getSession(), $this->getElement('slug'));
        }
    }

    public function fillSlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    public function fillMetaKeywords(string $metaKeywords): void
    {
        $this->getDocument()->fillField('Meta keywords', $metaKeywords);
    }

    public function fillMetaDescription(string $metaDescription): void
    {
        $this->getDocument()->fillField('Meta description', $metaDescription);
    }

    public function fillContent(string $content): void
    {
        WysiwygHelper::fillContent($this->getSession(), $this->getDocument(), $content);
    }

    public function associateSections(array $sectionsNames): void
    {
        Assert::isInstanceOf($this->getDriver(), Selenium2Driver::class);

        $dropdown = $this->getElement('association_dropdown_section');
        $dropdown->click();

        foreach ($sectionsNames as $sectionName) {
            $dropdown->waitFor(10, function () use ($sectionName) {
                return $this->hasElement('association_dropdown_section_item', [
                    '%item%' => $sectionName,
                ]);
            });

            $item = $this->getElement('association_dropdown_section_item', [
                '%item%' => $sectionName,
            ]);

            $item->click();
        }
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'slug' => '#bitbag_sylius_cms_plugin_page_translations_en_US_slug',
            'association_dropdown_section' => '.field > label:contains("Sections") ~ .sylius-autocomplete',
            'association_dropdown_section_item' => '.field > label:contains("Sections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
