<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ContainsContentElementTrait
{
    use DocumentAccessor;

    public function containsContentElement(string $contentElement): bool
    {
        $fieldName = match ($contentElement) {
            'Products carousel' => 'Products',
            'Products carousel by taxon' => 'Taxon',
            'Taxons list' => 'Taxons',
            default => $contentElement,
        };

        $contentElements = $this->getDocument()->findById('bitbag_sylius_cms_plugin_block_contentElements')
            ?? $this->getDocument()->findById('bitbag_sylius_cms_plugin_page_contentElements');

        if (null === $contentElements) {
            throw new \InvalidArgumentException('Content elements container not found');
        }

        return $contentElements->hasField($fieldName);
    }
}