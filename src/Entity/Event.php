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

class Event implements EventInterface
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

    /** @var string|null */
    protected $code;

    /** @var \DateTimeImmutable|null */
    protected $publishAt;

    /** @var \DateTimeImmutable|null */
    protected $startAt;

    /** @var \DateTimeImmutable|null */
    protected $endAt;

    /** @var string|null */
    protected $location;

    public function __construct()
    {
        $this->initializeProductsCollection();
        $this->initializeSectionsCollection();
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
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getSlug();
    }

    public function setSlug(?string $slug): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setSlug($slug);
    }

    public function getMetaKeywords(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getMetaKeywords();
    }

    public function setMetaKeywords(?string $metaKeywords): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setMetaKeywords($metaKeywords);
    }

    public function getMetaDescription(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getMetaDescription();
    }

    public function setMetaDescription(?string $metaDescription): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setMetaDescription($metaDescription);
    }

    public function getContent(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getContent();
    }

    public function setContent(?string $content): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setContent($content);
    }

    public function getName(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getName();
    }

    public function setName(?string $name): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setName($name);
    }

    public function getNameWhenLinked(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getNameWhenLinked();
    }

    public function setNameWhenLinked(?string $nameWhenLinked): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setNameWhenLinked($nameWhenLinked);
    }

    public function getDescriptionWhenLinked(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getDescriptionWhenLinked();
    }

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setDescriptionWhenLinked($descriptionWhenLinked);
    }

    public function getBreadcrumb(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getBreadcrumb();
    }

    public function setBreadcrumb(?string $breadcrumb): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setBreadcrumb($breadcrumb);
    }

    public function getImage(): ?MediaInterface
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getImage();
    }

    public function setImage(?MediaInterface $image): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setImage($image);
    }

    public function getTitle(): ?string
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();

        return $eventTranslationInterface->getTitle();
    }

    public function setTitle(?string $title): void
    {
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $this->getEventTranslation();
        $eventTranslationInterface->setTitle($title);
    }

    /**
     * @return EventTranslationInterface|TranslationInterface
     */
    protected function getEventTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): EventTranslationInterface
    {
        return new EventTranslation();
    }

    public function getPublishAt(): ?\DateTimeImmutable
    {
        return $this->publishAt;
    }

    public function setPublishAt(?\DateTimeImmutable $publishAt): void
    {
        $this->publishAt = $publishAt;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    /**
     * @param \DateTimeImmutable|null $startAt
     */
    public function setStartAt(?\DateTimeImmutable $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    /**
     * @param \DateTimeImmutable|null $endAt
     */
    public function setEndAt(?\DateTimeImmutable $endAt): void
    {
        $this->endAt = $endAt;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }
}
