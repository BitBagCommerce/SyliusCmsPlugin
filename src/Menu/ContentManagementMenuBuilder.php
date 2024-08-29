<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ContentManagementMenuBuilder
{
    public function __construct(private MenuReorderInterface $menuReorder)
    {
    }

    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();

        $cmsRootMenuItem = $menu
            ->addChild('sylius_cms')
            ->setLabel('sylius_cms_plugin.ui.cms')
        ;

        $cmsRootMenuItem
            ->addChild('collections', [
                'route' => 'sylius_cms_plugin_admin_collection_index',
            ])
            ->setLabel('sylius_cms_plugin.ui.collections')
            ->setLabelAttribute('icon', 'grid layout')
        ;

        $cmsRootMenuItem
            ->addChild('templates', [
                'route' => 'sylius_cms_plugin_admin_template_index',
            ])
            ->setLabel('sylius_cms_plugin.ui.templates')
            ->setLabelAttribute('icon', 'clone')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'sylius_cms_plugin_admin_page_index',
            ])
            ->setLabel('sylius_cms_plugin.ui.pages')
            ->setLabelAttribute('icon', 'sticky note')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'sylius_cms_plugin_admin_block_index',
            ])
            ->setLabel('sylius_cms_plugin.ui.blocks')
            ->setLabelAttribute('icon', 'block layout')
        ;

        $cmsRootMenuItem
            ->addChild('media', [
                'route' => 'sylius_cms_plugin_admin_media_index',
            ])
            ->setLabel('sylius_cms_plugin.ui.media')
            ->setLabelAttribute('icon', 'file')
        ;

        $this->menuReorder->reorder($menu, 'sylius_cms', 'marketing');
    }
}
