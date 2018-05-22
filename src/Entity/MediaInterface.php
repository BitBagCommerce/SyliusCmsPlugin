<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface MediaInterface extends ResourceInterface
{
    const IMAGE_TYPE = 'image';

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getPath(): string;

    public function setPath(string $path): void;

    public function getFileType(): ?string;

    public function setFileType(string $fileType): void;
}
