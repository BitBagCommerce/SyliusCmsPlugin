<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityTrait;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsContentElementTrait;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutabilityTrait;
    use ContainsContentElementTrait;

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function fillNameIfItIsEmpty(string $name): void
    {
        if (empty($this->getDocument()->findField('Name')->getValue())) {
            $this->fillName($name);
        }
    }

    public function fillLink(string $link): void
    {
        $this->getDocument()->fillField('Link', $link);
    }

    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    public function disable(): void
    {
        $this->getDocument()->uncheckField('Enabled');
    }

    public function isBlockDisabled(): bool
    {
        return $this->getDocument()->findField('Enabled')->isChecked();
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
