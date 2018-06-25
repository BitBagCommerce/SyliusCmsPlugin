<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;

final class MediaTypeResolver implements MediaTypeResolverInterface
{
    public function resolveType(string $mimeType): string
    {
        if (preg_match('/^(image)\/\w{0,}$/', $mimeType)) {
            return MediaInterface::IMAGE_TYPE;
        }

        if (preg_match('/^(video)\/\w{0,}$/', $mimeType)) {
            return MediaInterface::VIDEO_TYPE;
        }

        return MediaInterface::FILE_TYPE;
    }
}
