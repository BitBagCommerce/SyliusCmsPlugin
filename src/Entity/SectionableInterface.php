<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface SectionableInterface
{
    public function initializeSectionsCollection(): void;

    /**
     * @return Collection|SectionInterface[]
     */
    public function getSections(): ?Collection;

    /**
     * @param SectionInterface $section
     *
     * @return bool
     */
    public function hasSection(SectionInterface $section): bool;

    /**
     * @param SectionInterface $section
     */
    public function addSection(SectionInterface $section): void;

    /**
     * @param SectionInterface $section
     */
    public function removeSection(SectionInterface $section): void;
}
