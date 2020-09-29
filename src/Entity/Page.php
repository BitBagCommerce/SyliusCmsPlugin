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

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Page implements PageInterface
{
    use ToggleableTrait;
    use ProductsAwareTrait;
    use SectionableTrait;
    use TimestampableTrait;
    use ChannelsAwareTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    public function __construct()
    {
        $this->initializeProductsCollection();
        $this->initializeSectionsCollection();
        $this->initializeTranslationsCollection();
        $this->initializeChannelsCollection();
        $this->initializeChannelsCollection();

        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getSlug(): ?string
    {
        return $this->getPageTranslation()->getSlug();
    }

    public function setSlug(?string $slug): void
    {
        $this->getPageTranslation()->setSlug($slug);
    }

    public function getMetaKeywords(): ?string
    {
        return $this->getPageTranslation()->getMetaKeywords();
    }

    public function setMetaKeywords(?string $metaKeywords): void
    {
        $this->getPageTranslation()->setMetaKeywords($metaKeywords);
    }

    public function getMetaDescription(): ?string
    {
        return $this->getPageTranslation()->getMetaDescription();
    }

    public function setMetaDescription(?string $metaDescription): void
    {
        $this->getPageTranslation()->setMetaDescription($metaDescription);
    }

    public function getContent(): ?string
    {
        return $this->getPageTranslation()->getContent();
    }

    public function setContent(?string $content): void
    {
        $this->getPageTranslation()->setContent($content);
    }

    public function getName(): ?string
    {
        return $this->getPageTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getPageTranslation()->setName($name);
    }

    public function getNameWhenLinked(): ?string
    {
        return $this->getPageTranslation()->getNameWhenLinked();
    }

    public function setNameWhenLinked(?string $nameWhenLinked): void
    {
        $this->getPageTranslation()->setNameWhenLinked($nameWhenLinked);
    }

    public function getDescriptionWhenLinked(): ?string
    {
        return $this->getPageTranslation()->getDescriptionWhenLinked();
    }

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void
    {
        $this->getPageTranslation()->setDescriptionWhenLinked($descriptionWhenLinked);
    }

    public function getBreadcrumb(): ?string
    {
        return $this->getPageTranslation()->getBreadcrumb();
    }

    public function setBreadcrumb(?string $breadcrumb): void
    {
        $this->getPageTranslation()->setBreadcrumb($breadcrumb);
    }

    public function getImage(): ?ImageInterface
    {
        return $this->getPageTranslation()->getImage();
    }

    public function setImage(?ImageInterface $image): void
    {
        $this->getPageTranslation()->setImage($image);
    }

    public function getTitle(): ?string
    {
        return $this->getPageTranslation()->getTitle();
    }

    public function setTitle(?string $title): void
    {
        $this->getPageTranslation()->setTitle($title);
    }

    /**
     * @return PageTranslationInterface|TranslationInterface|null
     */
    protected function getPageTranslation(): PageTranslationInterface
    {
        return $this->getTranslation();
    }

    /**
     * @return PageTranslationInterface|TranslationInterface
     */
    protected function createTranslation(): TranslationInterface
    {
        return new PageTranslation();
    }
}
