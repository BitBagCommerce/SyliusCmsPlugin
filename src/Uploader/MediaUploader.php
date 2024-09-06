<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Uploader;

use Gaufrette\Filesystem;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Webmozart\Assert\Assert;

final class MediaUploader implements MediaUploaderInterface
{
    public function __construct(private Filesystem $filesystem)
    {
    }

    public function upload(MediaInterface $media, string $pathPrefix): void
    {
        if (!$media->hasFile()) {
            return;
        }

        $file = $media->getFile();
        Assert::notNull($file, sprintf('File for media identified by id: "%s" is null', $media->getId()));
        if (null !== $media->getPath() && $this->has($media->getPath())) {
            $this->remove($media->getPath());
        }

        $originalName = null;
        if ($media->getSaveWithOriginalName()) {
            $originalName = $file->getClientOriginalName();
        }

        do {
            $hash = bin2hex(random_bytes(16));
            $path = $this->expandPath($hash . '.' . $file->guessExtension(), $pathPrefix, $originalName);
        } while ($this->filesystem->has($path));

        $media->setPath('/' . $path);
        $media->setMimeType($file->getMimeType());
        $file = $media->getFile();
        Assert::notNull($file, sprintf('File for media identified by id: "%s" is null', $media->getId()));
        $mimeType = $media->getMimeType();
        if (null !== $mimeType && str_contains($mimeType, 'image')) {
            $sizes = getimagesize($file->getPathname());
            if (false !== $sizes) {
                [$width, $height] = $sizes;
                $media->setWidth($width);
                $media->setHeight($height);
            }
        }

        $mediaPath = $media->getPath();
        $fileContents = file_get_contents($file->getPathname());
        Assert::notNull($mediaPath, sprintf('Media path for media identified by id: "%s" is null', $media->getId()));
        Assert::notFalse($fileContents, sprintf('File contents for file identified by id: "%s" is false', $file->getPath()));
        $this->filesystem->write(
            $mediaPath,
            $fileContents,
        );
    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function expandPath(
        string $path,
        string $pathPrefix,
        ?string $originalName = null,
    ): string {
        return sprintf(
            '%s/%s/%s/%s',
            $pathPrefix,
            substr($path, 0, 2),
            substr($path, 2, 2),
            $originalName ?? substr($path, 4),
        );
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }
}
