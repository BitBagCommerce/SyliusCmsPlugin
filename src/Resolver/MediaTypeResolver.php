<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
