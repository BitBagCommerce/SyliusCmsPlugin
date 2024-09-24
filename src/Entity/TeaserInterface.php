<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

interface TeaserInterface
{
    public function getTeaserTitle(): ?string;

    public function setTeaserTitle(?string $teaserTitle): void;

    public function getTeaserContent(): ?string;

    public function setTeaserContent(?string $teaserContent): void;

    public function getTeaserImage(): ?MediaInterface;

    public function setTeaserImage(?MediaInterface $teaserImage): void;
}
