<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Media;

use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsErrorTrait;
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
        $this->getDocument()->fillField('Content', $content);
    }

    public function associateCollections(array $collectionsNames): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $dropdown = $this->getElement('association_dropdown_collection');
        $dropdown->click();

        foreach ($collectionsNames as $collectionName) {
            $dropdown->waitFor(5, function () use ($collectionName) {
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

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'association_dropdown_collection' => '.field > label:contains("Collections") ~ .sylius-autocomplete',
            'association_dropdown_collection_item' => '.field > label:contains("Collections") ~ .sylius-autocomplete > div.menu > div.item:contains("%item%")',
        ]);
    }
}
