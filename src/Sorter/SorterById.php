<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Sorter;

final class SorterById
{
    public static function sort(array $elements, string $direction = 'asc'): array
    {
        usort($elements, static function ($element1, $element2) use ($direction) {
            if ('asc' === $direction) {
                return $element1->getId() <=> $element2->getId();
            }

            return $element2->getId() <=> $element1->getId();
        });

        return $elements;
    }
}
