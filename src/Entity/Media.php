<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Symfony\Component\HttpFoundation\File\File;

class Media implements MediaInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $fileType;

    /** @var string */
    private $code;

    /** @var string */
    private $path;

    /** @var File */
    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): void
    {
        $this->fileType = $fileType;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getFile(): ?File
    {
        if (null === $this->fileType && null !== $this->path) {
            $this->file = new File($this->path);
        }

        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }
}
