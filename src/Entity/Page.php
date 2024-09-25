<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\CmsPlugin\Entity\Trait\ChannelsAwareTrait;
use Sylius\CmsPlugin\Entity\Trait\CollectibleTrait;
use Sylius\CmsPlugin\Entity\Trait\ContentElementsAwareTrait;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Resource\Model\TranslationInterface;

class Page implements PageInterface
{
    use ToggleableTrait;
    use CollectibleTrait;
    use TimestampableTrait;
    use ChannelsAwareTrait;
    use ContentElementsAwareTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    protected ?int $id = null;

    protected ?string $code = null;

    protected ?string $name = null;

    protected ?string $template = null;

    protected ?\DateTimeImmutable $publishAt;

    public function __construct()
    {
        $this->initializeCollectionsCollection();
        $this->initializeChannelsCollection();
        $this->initializeTranslationsCollection();
        $this->initializeContentElementsCollection();

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

    public function getTeaserTitle(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getTeaserTitle();
    }

    public function setTeaserTitle(?string $teaserTitle): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setTeaserTitle($teaserTitle);
    }

    public function getTeaserContent(): ?string
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getTeaserContent();
    }

    public function setTeaserContent(?string $teaserContent): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setTeaserContent($teaserContent);
    }

    public function getTeaserImage(): ?MediaInterface
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();

        return $pageTranslationInterface->getTeaserImage();
    }

    public function setTeaserImage(?MediaInterface $teaserImage): void
    {
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $this->getPageTranslation();
        $pageTranslationInterface->setTeaserImage($teaserImage);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
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

    public function getPublishAt(): ?\DateTimeImmutable
    {
        return $this->publishAt;
    }

    public function setPublishAt(?\DateTimeImmutable $publishAt): void
    {
        $this->publishAt = $publishAt;
    }

    protected function getPageTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): PageTranslationInterface
    {
        return new PageTranslation();
    }
}
