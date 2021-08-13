<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface PageTranslationInterface extends ResourceInterface, TranslationInterface
{
    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getSlug(): ?string;

    public function setSlug(?string $slug): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getBreadcrumb(): ?string;

    public function setBreadcrumb(?string $breadcrumb): void;

    public function getNameWhenLinked(): ?string;

    public function setNameWhenLinked(?string $nameWhenLinked): void;

    public function getDescriptionWhenLinked(): ?string;

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void;

    public function getMetaKeywords(): ?string;

    public function setMetaKeywords(?string $metaKeywords): void;

    public function getMetaDescription(): ?string;

    public function setMetaDescription(?string $metaDescription): void;

    public function getImage(): ?MediaInterface;

    public function setImage(?MediaInterface $image): void;

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;
}
