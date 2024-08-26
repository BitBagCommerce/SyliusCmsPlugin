<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
