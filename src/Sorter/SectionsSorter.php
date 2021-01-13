<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Sorter;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;

final class SectionsSorter implements SectionsSorterInterface
{
    public function sortBySections(array $pages): array
    {
        $result = [];

        /** @var PageInterface $page */
        foreach ($pages as $page) {
            foreach ($page->getSections() as $section) {
                $sectionCode = $section->getCode();
                if (!array_key_exists($sectionCode, $result)) {
                    $result[$sectionCode] = [];
                    $result[$sectionCode]['section'] = $section;
                }

                $result[$sectionCode][] = $page;
            }
        }
        return $result;
    }
}
