<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Behaviour;

use Sylius\Behat\Behaviour\DocumentAccessor;

trait ContainsContentElementTrait
{
    use DocumentAccessor;

    public function containsContentElement(string $contentElement): bool
    {
        $isAutocompleteField = match ($contentElement) {
            'Single media',
            'Multiple media',
            'Products carousel',
            'Products carousel by Taxon',
            'Products grid',
            'Products grid by Taxon',
            'Taxons list' => true,
            default => false,
        };

        $contentElements = $this->getDocument()->findById('sylius_cms_block_contentElements')
            ?? $this->getDocument()->findById('sylius_cms_page_contentElements');

        if (null === $contentElements) {
            throw new \InvalidArgumentException('Content elements container not found.');
        }

        return $isAutocompleteField
            ? $contentElements->has('css', 'input.search')
            : $contentElements->hasField($contentElement);
    }
}
