<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\MediaProvider;

final class FilenameHelper
{
    private const REPLACE_WITH = '';

    public static function removeSlashes(string $string, string $replaceWith = self::REPLACE_WITH): string
    {
        return str_replace('\\', $replaceWith, str_replace('/', $replaceWith, $string));
    }
}
