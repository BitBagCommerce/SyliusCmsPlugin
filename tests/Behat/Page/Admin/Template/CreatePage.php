<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Template;

use DMore\ChromeDriver\ChromeDriver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;
use Tests\BitBag\SyliusCmsPlugin\Behat\Helpers\ContentElementHelper;
use Webmozart\Assert\Assert;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function chooseType(string $name): void
    {
        $this->getDocument()->selectFieldOption('Type', $name);
    }

    public function clickOnAddContentElementButton(): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $addButton = $this->getElement('content_elements_add_button');
        $addButton->click();

        $addButton->waitFor(1, function (): bool {
            return $this->hasElement('content_elements_select_type');
        });
    }

    public function selectContentElement(string $contentElement): void
    {
        Assert::isInstanceOf($this->getDriver(), ChromeDriver::class);

        $select = $this->getElement('content_elements_select_type');
        $select->selectOption($contentElement);
        $select->waitFor(1, function () use ($contentElement): bool {
            return $this->hasElement(
                ContentElementHelper::getDefinedElementThatShouldAppearAfterSelectContentElement($contentElement),
            );
        });
    }

    protected function getDefinedElements(): array
    {
        return array_merge(
            parent::getDefinedElements(),
            ContentElementHelper::getDefinedContentElements(),
            [
                'content_elements_add_button' => '#bitbag_sylius_cms_plugin_template_contentElements a[data-form-collection="add"]',
            ],
        );
    }
}
