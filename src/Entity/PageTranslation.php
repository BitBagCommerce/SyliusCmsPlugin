<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;

class PageTranslation extends AbstractTranslation implements PageTranslationInterface
{
    /** @var int */
    protected $id;

    /** @var string|null */
    protected $slug;

    /** @var MediaInterface|null */
    protected $image;

    /** @var string|null */
    protected $name;

    /** @var string|null */
    protected $content;

    /** @var string|null */
    protected $metaKeywords;

    /** @var string|null */
    protected $metaDescription;

    /** @var string|null */
    protected $nameWhenLinked;

    /** @var string|null */
    protected $descriptionWhenLinked;

    /** @var string|null */
    protected $breadcrumb;

    /** @var string|null */
    protected $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getImage(): ?MediaInterface
    {
        return $this->image;
    }

    public function setImage(?MediaInterface $image): void
    {
        $this->image = $image;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getBreadcrumb(): ?string
    {
        return $this->breadcrumb;
    }

    public function setBreadcrumb(?string $breadcrumb): void
    {
        $this->breadcrumb = $breadcrumb;
    }

    public function getNameWhenLinked(): ?string
    {
        return $this->nameWhenLinked;
    }

    public function setNameWhenLinked(?string $nameWhenLinked): void
    {
        $this->nameWhenLinked = $nameWhenLinked;
    }

    public function getDescriptionWhenLinked(): ?string
    {
        return $this->descriptionWhenLinked;
    }

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void
    {
        $this->descriptionWhenLinked = $descriptionWhenLinked;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(?string $metaKeywords): void
    {
        $this->metaKeywords = $metaKeywords;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
}
