<?php

namespace BitBag\CmsPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ContentManagementMenuBuilder
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function buildMenu(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('bitbag-content-management')
            ->setLabel('bitbag.ui.cms_plugin.content_management')
        ;

        $newSubmenu
            ->addChild('bitbag-content-management-blocks', [
                'route' => 'bitbag_admin_block_index'
            ])
            ->setLabel('bitbag.ui.cms_plugin.blocks')
        ;
    }
}