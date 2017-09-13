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
            ->addChild('bitbag_cms')
            ->setLabel('bitbag.cms.cms')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'bitbag_admin_block_index'
            ])
            ->setLabel('bitbag.cms.blocks')
            ->setLabelAttribute('icon', 'block layout')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'bitbag_admin_page_index'
            ])
            ->setLabel('bitbag.cms.pages')
            ->setLabelAttribute('icon', 'sticky note')
        ;
    }
}