<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Uploader;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Webmozart\Assert\Assert;

final class MediaUploader implements MediaUploaderInterface
{
    /** @var Filesystem */
    private $filesystem;

    /** @var string */
    private $projectDir;

    public function __construct(Filesystem $filesystem, string $projectDir)
    {
        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
    }

    public function upload(MediaInterface $media, string $pathPrefix): void
    {
        if (!$media->hasFile()) {
            return;
        }

        $file = $media->getFile();

        /** @var File $file */
        Assert::isInstanceOf($file, File::class);

        if (null !== $media->getPath() && $this->has($media->getPath())) {
            $this->remove($media->getPath());
        }

        do {
            $hash = bin2hex(random_bytes(16));
            $path = $this->expandPath($hash . '.' . $file->guessExtension(), $pathPrefix);
        } while ($this->filesystem->has($path));

        $media->setPath($path);
        $media->setOriginalPath(sprintf('%s/%s', $this->projectDir, $path));
        $media->setMimeType($file->getMimeType());

        $this->filesystem->write(
            $media->getPath(),
            file_get_contents($media->getFile()->getPathname())
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
