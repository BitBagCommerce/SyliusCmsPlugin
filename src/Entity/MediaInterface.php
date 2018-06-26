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
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\File;

interface MediaInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    ProductsAwareInterface,
    SectionableInterface
{
    public const IMAGE_TYPE = 'image';
    public const VIDEO_TYPE = 'video';
    public const FILE_TYPE = 'file';

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getPath(): ?string;

    public function setPath(?string $path): void;

    public function getOriginalPath(): ?string;

    public function setOriginalPath(?string $originalPath): void;

    public function getFile(): ?File;

    public function setFile(?File $file): void;

    public function hasFile(): bool;

    public function getFileType(): ?string;

    public function setFileType(?string $fileType): void;

    public function getMimeType(): ?string;

    public function setMimeType(?string $mimeType): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
