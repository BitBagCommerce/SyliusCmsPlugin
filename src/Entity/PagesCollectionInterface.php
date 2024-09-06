<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface PagesCollectionInterface
{
    public function initializePagesCollection(): void;

    public function getPages(): ?Collection;

    public function hasPage(PageInterface $page): bool;

    public function addPage(PageInterface $page): void;

    public function removePage(PageInterface $page): void;
}
