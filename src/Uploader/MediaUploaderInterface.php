<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Uploader;

use Sylius\CmsPlugin\Entity\MediaInterface;

interface MediaUploaderInterface
{
    public function upload(MediaInterface $media, string $pathPrefix): void;

    public function remove(string $path): bool;
}
