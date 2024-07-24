<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Sorter;

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
