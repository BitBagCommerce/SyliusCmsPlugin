<?php

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
