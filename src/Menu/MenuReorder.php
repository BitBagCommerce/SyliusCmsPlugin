<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Menu;

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
