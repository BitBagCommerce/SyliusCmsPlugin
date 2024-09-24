<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Menu;

use Knp\Menu\ItemInterface;

final class MenuReorder implements MenuReorderInterface
{
    public function reorder(ItemInterface $menu, string $newItemKey, string $targetItemKey): void
    {
        $menuItems = $menu->getChildren();

        $newMenuItem = $menu->getChild($newItemKey);
        unset($menuItems[$newItemKey]);

        $targetPosition = array_search($targetItemKey, array_keys($menuItems), true);

        if (null !== $newMenuItem && false !== $targetPosition) {
            $menuItems = array_slice($menuItems, 0, $targetPosition + 1, true) +
                [$newItemKey => $newMenuItem] +
                array_slice($menuItems, $targetPosition + 1, null, true);

            $menuItems = array_filter($menuItems, static function ($item) {
                return $item instanceof ItemInterface;
            });

            $menu->setChildren($menuItems);
        }
    }
}
