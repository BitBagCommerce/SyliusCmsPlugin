<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ContentManagementMenuBuilder
{
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('bitbag_cms')
            ->setLabel('bitbag_sylius_cms_plugin.ui.cms')
        ;

        $cmsRootMenuItem
            ->addChild('collections', [
                'route' => 'bitbag_sylius_cms_plugin_admin_collection_index',
            ])
            ->setLabel('bitbag_sylius_cms_plugin.ui.collections')
            ->setLabelAttribute('icon', 'grid layout')
        ;

        $cmsRootMenuItem
            ->addChild('templates', [
                'route' => 'bitbag_sylius_cms_plugin_admin_template_index',
            ])
            ->setLabel('bitbag_sylius_cms_plugin.ui.templates')
            ->setLabelAttribute('icon', 'clone')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'bitbag_sylius_cms_plugin_admin_page_index',
            ])
            ->setLabel('bitbag_sylius_cms_plugin.ui.pages')
            ->setLabelAttribute('icon', 'sticky note')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'bitbag_sylius_cms_plugin_admin_block_index',
            ])
            ->setLabel('bitbag_sylius_cms_plugin.ui.blocks')
            ->setLabelAttribute('icon', 'block layout')
        ;

        $cmsRootMenuItem
            ->addChild('media', [
                'route' => 'bitbag_sylius_cms_plugin_admin_media_index',
            ])
            ->setLabel('bitbag_sylius_cms_plugin.ui.media')
            ->setLabelAttribute('icon', 'file')
        ;

        $this->reorderMenu($menu, 'bitbag_cms', 'marketing');
    }

    private function reorderMenu(ItemInterface $menu, string $newItemKey, string $targetItemKey): void
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
