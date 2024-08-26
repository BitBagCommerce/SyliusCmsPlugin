<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\CmsPlugin\Entity\PageInterface;

trait PagesCollectionTrait
{
    protected Collection $pages;

    public function initializePagesCollection(): void
    {
        $this->pages = new ArrayCollection();
    }

    public function getPages(): ?Collection
    {
        return $this->pages;
    }

    public function hasPage(PageInterface $page): bool
    {
        return $this->pages->contains($page);
    }

    public function addPage(PageInterface $page): void
    {
        if (false === $this->hasPage($page)) {
            $this->pages->add($page);
        }
    }

    public function removePage(PageInterface $page): void
    {
        if (true === $this->hasPage($page)) {
            $this->pages->removeElement($page);
        }
    }
}
