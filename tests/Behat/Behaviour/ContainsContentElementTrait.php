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

        return $this->getDocument()->hasField($fieldName);
    }
}
