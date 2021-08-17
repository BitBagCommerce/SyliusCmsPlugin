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

trait SectionableTrait
{
    /** @var Collection|SectionInterface[] */
    protected $sections;

    public function initializeSectionsCollection(): void
    {
        $this->sections = new ArrayCollection();
    }

    public function getSections(): ?Collection
    {
        return $this->sections;
    }

    public function hasSection(SectionInterface $section): bool
    {
        return $this->sections->contains($section);
    }

    public function addSection(SectionInterface $section): void
    {
        if (false === $this->hasSection($section)) {
            $this->sections->add($section);
        }
    }

    public function removeSection(SectionInterface $section): void
    {
        if (true === $this->hasSection($section)) {
            $this->sections->removeElement($section);
        }
    }
}
