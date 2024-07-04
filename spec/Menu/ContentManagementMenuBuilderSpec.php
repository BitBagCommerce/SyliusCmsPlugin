<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Menu;

use BitBag\SyliusCmsPlugin\Menu\ContentManagementMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ContentManagementMenuBuilderSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentManagementMenuBuilder::class);
    }

    public function it_build_menu(
        MenuBuilderEvent $menuBuilderEvent,
        ItemInterface $menu,
        ItemInterface $cmsRootMenuItem
    ): void {
        $menuBuilderEvent->getMenu()->willReturn($menu);
        $menu->addChild('bitbag_cms')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.cms')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem
            ->addChild('blocks', ['route' => 'bitbag_sylius_cms_plugin_admin_block_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.blocks')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'block layout')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('pages', ['route' => 'bitbag_sylius_cms_plugin_admin_page_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.pages')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'sticky note')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('collections', ['route' => 'bitbag_sylius_cms_plugin_admin_collection_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.collections')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'grid layout')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('media', ['route' => 'bitbag_sylius_cms_plugin_admin_media_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.media')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'file')->shouldBeCalled();

        $this->buildMenu($menuBuilderEvent);
    }
}
