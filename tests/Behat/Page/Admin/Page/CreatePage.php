<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Page;

use Behat\Mink\Exception\ElementNotFoundException;
use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Sylius\Behat\Service\SlugGenerationHelper;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\FormHelper;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function chooseImage(string $code): void
    {
        FormHelper::fillHiddenInput($this->getSession(), self::IMAGE_FORM_ID, $code);
    }

    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);

        if ($this->getDriver() instanceof ChromeDriver) {
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
        $this->getDocument()->fillField('Content', $content);
    }

    public function associateCollections(array $collectionsNames): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $dropdown = $this->getElement('association_dropdown_collection');
        $dropdown->click();

        foreach ($collectionsNames as $collectionName) {
            $dropdown->waitFor(10, function () use ($collectionName): bool {
                return $this->hasElement('association_dropdown_collection_item', [
                    '%item%' => $collectionName,
                ]);
            });

            $item = $this->getElement('association_dropdown_collection_item', [
                '%item%' => $collectionName,
            ]);

            $item->click();
        }
    }

    /**
     * @throws ElementNotFoundException
     */
    public function addTextareaContentElementWithContent(string $content): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $addButton = $this->getElement('content_elements_add_button');
        $addButton->click();

        $addButton->waitFor(3, function (): bool {
            return $this->hasElement('content_elements_textarea');
        });

        $textarea = $this->getElement('content_elements_textarea');
        $textarea->setValue($content);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'slug' => '#bitbag_sylius_cms_plugin_page_translations_en_US_slug',
            'association_dropdown_collection' => '.field > label:contains("Collections") ~ .sylius-autocomplete',
            'association_dropdown_collection_item' => '.field > label:contains("Collections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
            'content_elements_add_button' => '#bitbag_sylius_cms_plugin_block_contentElements a[data-form-collection="add"]',
            'content_elements_textarea' => '.field > label:contains("Textarea") ~ textarea',
        ]);
    }
}
