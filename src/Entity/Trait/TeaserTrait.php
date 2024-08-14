<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity\Trait;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;

trait TeaserTrait
{
    protected ?string $teaserTitle = null;

    protected ?string $teaserContent = null;

    protected ?MediaInterface $teaserImage = null;

    public function getTeaserTitle(): ?string
    {
        return $this->teaserTitle;
    }

    public function setTeaserTitle(?string $teaserTitle): void
    {
        $this->teaserTitle = $teaserTitle;
    }

    public function getTeaserContent(): ?string
    {
        return $this->teaserContent;
    }

    public function setTeaserContent(?string $teaserContent): void
    {
        $this->teaserContent = $teaserContent;
    }

    public function getTeaserImage(): ?MediaInterface
    {
        return $this->teaserImage;
    }

    public function setTeaserImage(?MediaInterface $teaserImage): void
    {
        $this->teaserImage = $teaserImage;
    }
}
