<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface PageTranslationInterface extends ResourceInterface, TranslationInterface, TeaserInterface
{
    public function getSlug(): ?string;

    public function setSlug(?string $slug): void;

    public function getMetaKeywords(): ?string;

    public function setMetaKeywords(?string $metaKeywords): void;

    public function getMetaDescription(): ?string;

    public function setMetaDescription(?string $metaDescription): void;

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;

    public function getTeaserTitle(): ?string;

    public function getTeaserContent(): ?string;

    public function getTeaserImage(): ?MediaInterface;
}
