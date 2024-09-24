<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\CmsPlugin\Entity\MediaInterface;

trait MediaCollectionTrait
{
    protected Collection $media;

    public function initializeMediaCollection(): void
    {
        $this->media = new ArrayCollection();
    }

    public function getMedia(): ?Collection
    {
        return $this->media;
    }

    public function hasMedium(MediaInterface $media): bool
    {
        return $this->media->contains($media);
    }

    public function addMedium(MediaInterface $media): void
    {
        if (false === $this->hasMedium($media)) {
            $this->media->add($media);
        }
    }

    public function removeMedium(MediaInterface $media): void
    {
        if (true === $this->hasMedium($media)) {
            $this->media->removeElement($media);
        }
    }
}
