<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Uploader;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Gaufrette\Filesystem;

final class MediaUploader implements MediaUploaderInterface
{
    /** @var Filesystem */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(MediaInterface $media, string $pathPrefix): void
    {
        if (!$media->hasFile()) {
            return;
        }

        $file = $media->getFile();
        assert(null !== $file);
        if (null !== $media->getPath() && $this->has($media->getPath())) {
            $this->remove($media->getPath());
        }

        do {
            $hash = bin2hex(random_bytes(16));
            $path = $this->expandPath($hash . '.' . $file->guessExtension(), $pathPrefix);
        } while ($this->filesystem->has($path));

        $media->setPath('/' . $path);
        $media->setMimeType($file->getMimeType());
        $file = $media->getFile();
        assert(null !== $file);
        $mimeType = $media->getMimeType();
        if (null !== $mimeType && false !== strpos($mimeType, 'image')) {
            [$width, $height] = getimagesize($file->getPathname());
            $media->setWidth($width);
            $media->setHeight($height);
        }

        $mediaPath = $media->getPath();
        $fileContents = file_get_contents($file->getPathname());
        assert(null !== $mediaPath && false !== $fileContents);
        $this->filesystem->write(
            $mediaPath,
            $fileContents
        );
    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function expandPath(string $path, string $pathPrefix): string
    {
        return sprintf(
            '%s/%s/%s/%s',
            $pathPrefix,
            substr($path, 0, 2),
            substr($path, 2, 2),
            substr($path, 4)
        );
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }
}
