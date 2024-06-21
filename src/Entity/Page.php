<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Page implements PageInterface
{
    use ToggleableTrait;
    use ProductsAwareTrait;
    use CollectibleTrait;
    use TimestampableTrait;
    use ChannelsAwareTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    /** @var int */
    protected $id;

    /** @var string|null */
    protected $code;

    /** @var \DateTimeImmutable|null */
    protected $publishAt;

    public function __construct()
    {
        $this->initializeProductsCollection();
        $this->initializeCollectionsCollection();
        $this->initializeTranslationsCollection();
        $this->initializeChannelsCollection();

        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
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
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getSlug();
    }

    public function setSlug(?string $slug): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setSlug($slug);
    }

    public function getMetaKeywords(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getMetaKeywords();
    }

    public function setMetaKeywords(?string $metaKeywords): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setMetaKeywords($metaKeywords);
    }

    public function getMetaDescription(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getMetaDescription();
    }

    public function setMetaDescription(?string $metaDescription): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setMetaDescription($metaDescription);
    }

    public function getContent(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getContent();
    }

    public function setContent(?string $content): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setContent($content);
    }

    public function getName(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getName();
    }

    public function setName(?string $name): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setName($name);
    }

    public function getNameWhenLinked(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getNameWhenLinked();
    }

    public function setNameWhenLinked(?string $nameWhenLinked): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setNameWhenLinked($nameWhenLinked);
    }

    public function getDescriptionWhenLinked(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getDescriptionWhenLinked();
    }

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setDescriptionWhenLinked($descriptionWhenLinked);
    }

    public function getBreadcrumb(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getBreadcrumb();
    }

    public function setBreadcrumb(?string $breadcrumb): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setBreadcrumb($breadcrumb);
    }

    public function getImage(): ?MediaInterface
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getImage();
    }

    public function setImage(?MediaInterface $image): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setImage($image);
    }

    public function getTitle(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getTitle();
    }

    public function setTitle(?string $title): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setTitle($title);
    }

    /**
     * @return PageTranslationInterface|TranslationInterface
     */
    protected function getPageTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): PageTranslationInterface
    {
        return new PageTranslation();
    }

    public function getPublishAt(): ?\DateTimeImmutable
    {
        return $this->publishAt;
    }

    public function setPublishAt(?\DateTimeImmutable $publishAt): void
    {
        $this->publishAt = $publishAt;
    }
}
