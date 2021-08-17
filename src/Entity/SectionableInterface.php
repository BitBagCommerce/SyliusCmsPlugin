<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

    public function hasSection(SectionInterface $section): bool;

    public function addSection(SectionInterface $section): void;

    public function removeSection(SectionInterface $section): void;
}
