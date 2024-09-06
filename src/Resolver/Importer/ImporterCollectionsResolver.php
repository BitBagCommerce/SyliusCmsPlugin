<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Assigner\CollectionsAssignerInterface;
use Sylius\CmsPlugin\Entity\CollectibleInterface;

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
