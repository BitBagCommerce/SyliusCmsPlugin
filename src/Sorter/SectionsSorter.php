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

final class SectionsSorter implements SectionsSorterInterface
{
    public function sortBySections(array $pages): array
    {
        $result = [];

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            $result = $this->updateSectionsArray($page, $result);
        }

        return $result;
    }

    private function updateSectionsArray(PageInterface $page, array $currentResult): array
    {
        Assert::isIterable($page->getSections());
        foreach ($page->getSections() as $section) {
            $sectionCode = $section->getCode();
            Assert::notNull($sectionCode);
            if (!array_key_exists($sectionCode, $currentResult)) {
                $currentResult[$sectionCode] = [];
                $currentResult[$sectionCode]['section'] = $section;
            }

            $currentResult[$sectionCode][] = $page;
        }

        return $currentResult;
    }
}
