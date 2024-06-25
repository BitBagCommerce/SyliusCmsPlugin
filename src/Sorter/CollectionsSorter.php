<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Sorter;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Webmozart\Assert\Assert;

final class CollectionsSorter implements CollectionsSorterInterface
{
    public function sortByCollections(array $pages): array
    {
        $result = [];

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            $result = $this->updateCollectionsArray($page, $result);
        }

        return $result;
    }

    private function updateCollectionsArray(PageInterface $page, array $currentResult): array
    {
        Assert::isIterable($page->getCollections());
        foreach ($page->getCollections() as $collection) {
            $collectionCode = $collection->getCode();
            Assert::notNull($collectionCode);
            if (!array_key_exists($collectionCode, $currentResult)) {
                $currentResult[$collectionCode] = [];
                $currentResult[$collectionCode]['collection'] = $collection;
            }

            $currentResult[$collectionCode][] = $page;
        }

        return $currentResult;
    }
}
