<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface MediaInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    ProductsAwareInterface,
    CollectionableInterface,
    ChannelsAwareInterface,
    ContentableInterface
{
    public const IMAGE_TYPE = 'image';

    public const VIDEO_TYPE = 'video';

    public const FILE_TYPE = 'file';

    public const DEFAULT_DOWNLOAD_NAME = 'media';

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getPath(): ?string;

    public function setPath(?string $path): void;

    public function getFile(): ?UploadedFile;

    public function setFile(?UploadedFile $file): void;

    public function hasFile(): bool;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getMimeType(): ?string;

    public function setMimeType(?string $mimeType): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getDownloadName(): string;

    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getAlt(): ?string;

    public function setAlt(?string $alt): void;

    public function getLink(): ?string;

    public function setLink(?string $link): void;

    public function getWidth(): ?int;

    public function setWidth(?int $width): void;

    public function getHeight(): ?int;

    public function setHeight(?int $height): void;

    public function getSaveWithOriginalName(): bool;

    public function setSaveWithOriginalName(bool $saveWithOriginalName): void;
}
