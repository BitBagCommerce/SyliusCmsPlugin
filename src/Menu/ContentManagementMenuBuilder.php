<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ContentManagementMenuBuilder
{
    /**
     * @param MenuBuilderEvent $menuBuilderEvent
     */
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent)
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('bitbag-content-management')
            ->setLabel('bitbag.ui.cms_plugin.content_management')
        ;

        $cmsRootMenuItem
            ->addChild('bitbag-content-management-blocks', [
                'route' => 'bitbag_admin_block_index'
            ])
            ->setLabel('bitbag.ui.cms_plugin.blocks')
        ;
    }
}