<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Downloader;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

final class ImageDownloader implements ImageDownloaderInterface
{
    /** @var Filesystem */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function download(string $url): File
    {
        $pathInfo = pathinfo($url);
        $extension = $pathInfo['extension'];
        $path = rtrim(sys_get_temp_dir(), \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR . md5(random_bytes(10)) . '.' . $extension;

        $this->filesystem->dumpFile($path, file_get_contents($url));

        return new File($path);
    }
}
