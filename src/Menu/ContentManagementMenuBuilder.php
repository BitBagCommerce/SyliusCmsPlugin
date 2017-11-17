<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ContentManagementMenuBuilder
{
    /**
     * @param MenuBuilderEvent $menuBuilderEvent
     */
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('bitbag_cms')
            ->setLabel('bitbag.ui.cms')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'bitbag_sylius_cms_plugin_admin_block_index'
            ])
            ->setLabel('bitbag.ui.blocks')
            ->setLabelAttribute('icon', 'block layout')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'bitbag_sylius_cms_plugin_admin_page_index'
            ])
            ->setLabel('bitbag.ui.pages')
            ->setLabelAttribute('icon', 'sticky note')
        ;

        $cmsRootMenuItem
            ->addChild('faq', [
                'route' => 'bitbag_sylius_cms_plugin_admin_frequently_asked_question_index'
            ])
            ->setLabel('bitbag.ui.faq')
            ->setLabelAttribute('icon', 'help')
        ;

        $cmsRootMenuItem
            ->addChild('sections', [
                'route' => 'bitbag_sylius_cms_plugin_admin_section_index'
            ])
            ->setLabel('bitbag.ui.sections')
            ->setLabelAttribute('icon', 'grid layout')
        ;
    }
}
