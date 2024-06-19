<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait MediableTrait
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
