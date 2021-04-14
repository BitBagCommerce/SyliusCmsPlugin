<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Media;

use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\WysiwygHelper;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function uploadFile(string $file): void
    {
        $path = __DIR__ . '/../../../Resources/images/' . $file;

        Assert::fileExists($path);

        $this->getDocument()->attachFileToField('File', realpath($path));
    }

    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function fillContent(string $content): void
    {
        WysiwygHelper::fillContent($this->getSession(), $this->getDocument(), $content);
    }

    public function associateSections(array $sectionsNames): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $dropdown = $this->getElement('association_dropdown_section');
        $dropdown->click();

        foreach ($sectionsNames as $sectionName) {
            $dropdown->waitFor(5, function () use ($sectionName) {
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
            'association_dropdown_section' => '.field > label:contains("Sections") ~ .sylius-autocomplete',
            'association_dropdown_section_item' => '.field > label:contains("Sections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
