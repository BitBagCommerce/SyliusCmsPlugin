<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver\Importer;

use BitBag\SyliusCmsPlugin\Assigner\CollectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectibleInterface;

final class ImporterCollectionsResolver implements ImporterCollectionsResolverInterface
{
    public function __construct(private CollectionsAssignerInterface $collectionsAssigner)
    {
    }

    public function resolve(CollectibleInterface $collectionable, ?string $collectionsRow): void
    {
        if (empty($collectionsRow)) {
            return;
        }

        $collectionCodes = explode(',', $collectionsRow);
        $collectionCodes = array_map(static function (string $element): string {
            return trim($element);
        }, $collectionCodes);

        $this->collectionsAssigner->assign($collectionable, $collectionCodes);
    }
}