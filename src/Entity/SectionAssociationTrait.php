<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
trait SectionAssociationTrait
{
    /**
     * @var Collection|SectionInterface[]
     */
    protected $sections;

    public function initializeSectionsCollection(): void
    {
        $this->sections = new ArrayCollection();
    }

    /**
     * @return Collection|SectionInterface[]
     */
    public function getSections(): ?Collection
    {
        return $this->sections;
    }

    /**
     * @param SectionInterface $section
     *
     * @return bool
     */
    public function hasSection(SectionInterface $section): bool
    {
        return $this->sections->contains($section);
    }

    /**
     * @param SectionInterface $section
     */
    public function addSection(SectionInterface $section): void
    {
        $this->sections->add($section);
    }

    /**
     * @param SectionInterface $section
     */
    public function removeSection(SectionInterface $section): void
    {
        if (true === $this->hasSection($section)) {
            $this->sections->removeElement($section);
        }
    }
}
