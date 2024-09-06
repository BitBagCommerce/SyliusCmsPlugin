<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Sorter;

use Sylius\CmsPlugin\Entity\PageInterface;
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
