<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Menu;

use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\CmsPlugin\Menu\ContentManagementMenuBuilder;
use Sylius\CmsPlugin\Menu\MenuReorderInterface;

final class ContentManagementMenuBuilderSpec extends ObjectBehavior
{
    public function let(MenuReorderInterface $menuReorder): void
    {
        $this->beConstructedWith($menuReorder);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentManagementMenuBuilder::class);
    }

    public function it_build_menu(
        MenuBuilderEvent $menuBuilderEvent,
        ItemInterface $menu,
        ItemInterface $cmsRootMenuItem,
    ): void {
        $menuBuilderEvent->getMenu()->willReturn($menu);
        $menu->addChild('sylius_cms')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabel('sylius_cms_plugin.ui.cms')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem
            ->addChild('blocks', ['route' => 'sylius_cms_plugin_admin_block_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('sylius_cms_plugin.ui.blocks')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'block layout')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('pages', ['route' => 'sylius_cms_plugin_admin_page_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('sylius_cms_plugin.ui.pages')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'sticky note')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('collections', ['route' => 'sylius_cms_plugin_admin_collection_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('sylius_cms_plugin.ui.collections')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'grid layout')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('templates', ['route' => 'sylius_cms_plugin_admin_template_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('sylius_cms_plugin.ui.templates')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'clone')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('media', ['route' => 'sylius_cms_plugin_admin_media_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('sylius_cms_plugin.ui.media')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'file')->shouldBeCalled();

        $menu->getChildren()->willReturn(['marketing' => $cmsRootMenuItem]);
        $menu->getChild('sylius_cms')->willReturn($cmsRootMenuItem);

        $menu->setChildren(['marketing' => $cmsRootMenuItem, 'sylius_cms' => $cmsRootMenuItem])->willReturn($menu);

        $this->buildMenu($menuBuilderEvent);
    }
}
