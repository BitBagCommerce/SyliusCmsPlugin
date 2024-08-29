<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityTrait;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsContentElementTrait;
use Tests\Sylius\CmsPlugin\Behat\Service\FormHelper;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutabilityTrait;
    use ContainsContentElementTrait;

    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function chooseImage(string $code): void
    {
        FormHelper::fillHiddenInput($this->getSession(), self::IMAGE_FORM_ID, $code);
    }

    public function changeTextareaContentElementValue(string $value): void
    {
        $this->getDocument()->fillField('Textarea', $value);
    }

    public function containsTextareaContentElementWithValue(string $value): bool
    {
        return $this->getDocument()->findField('Textarea')->getValue() === $value;
    }

    public function deleteContentElement(): void
    {
        $this->getDocument()->find('css', '.bb-collection-item-delete')->click();
    }
}
