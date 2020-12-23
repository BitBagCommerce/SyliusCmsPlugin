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

use BitBag\SyliusCmsPlugin\MediaProvider\FilenameHelper;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\HttpFoundation\File\File;

class Media implements MediaInterface
{
    use ToggleableTrait;
    use SectionableTrait;
    use ProductsAwareTrait;
    use ChannelsAwareTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    /** @var int */
    protected $id;

    /** @var string */
    protected $type;

    /** @var string */
    protected $code;

    /** @var string */
    protected $path;

    /** @var File */
    protected $file;

    /** @var string */
    protected $mimeType;

    /** @var string */
    protected $originalPath;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->initializeSectionsCollection();
        $this->initializeProductsCollection();
        $this->initializeChannelsCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public function hasFile(): bool
    {
        return null !== $this->file;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getName(): ?string
    {
        return $this->getMediaTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getMediaTranslation()->setName($name);
    }

    public function getDownloadName(): string
    {
        return FilenameHelper::removeSlashes($this->getName() ?? $this->getCode() ?? self::DEFAULT_DOWNLOAD_NAME);
    }

    public function getContent(): ?string
    {
        return $this->getMediaTranslation()->getContent();
    }

    public function setContent(?string $content): void
    {
        $this->getMediaTranslation()->setContent($content);
    }

    public function getAlt(): ?string
    {
        return $this->getMediaTranslation()->getAlt();
    }

    public function setAlt(?string $alt): void
    {
        $this->getMediaTranslation()->setAlt($alt);
    }

    public function getLink(): ?string
    {
        return $this->getMediaTranslation()->getLink();
    }

    public function setLink(?string $link): void
    {
        $this->getMediaTranslation()->setLink($link);
    }

    /**
     * @return MediaTranslationInterface|TranslationInterface
     */
    protected function getMediaTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): MediaTranslationInterface
    {
        return new MediaTranslation();
    }
    
    public function __toString(): string
    {
        return $this->getName() ?? $this->code;
    }
}
