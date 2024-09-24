<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface MediaCollectionInterface
{
    public function initializeMediaCollection(): void;

    public function getMedia(): ?Collection;

    public function hasMedium(MediaInterface $media): bool;

    public function addMedium(MediaInterface $media): void;

    public function removeMedium(MediaInterface $media): void;
}
