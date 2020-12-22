<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\MediaProvider;

final class FilenameHelper
{
    private const REPLACE_WITH = '';

    public static function removeSlashes(string $string, string $replaceWith = self::REPLACE_WITH): string
    {
        return str_replace('\\', $replaceWith, str_replace('/', $replaceWith, $string));
    }
}
