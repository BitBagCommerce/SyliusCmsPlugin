<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Menu;

use Knp\Menu\ItemInterface;

interface MenuReorderInterface
{
    public function reorder(ItemInterface $menu, string $newItemKey, string $targetItemKey): void;
}
