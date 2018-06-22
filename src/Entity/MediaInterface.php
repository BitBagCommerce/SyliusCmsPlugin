<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface MediaInterface extends ResourceInterface, TranslatableInterface
{
    const IMAGE_TYPE = 'image';

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getPath(): string;

    public function setPath(string $path): void;

    public function getFileType(): ?string;

    public function setFileType(string $fileType): void;
}
