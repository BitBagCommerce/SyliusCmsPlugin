<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Menu;

use BitBag\SyliusCmsPlugin\Menu\ContentManagementMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ContentManagementMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentManagementMenuBuilder::class);
    }

    function it_build_menu(
        MenuBuilderEvent $menuBuilderEvent,
        ItemInterface $menu,
        ItemInterface $cmsRootMenuItem
    ): void
    {
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
            ->addChild('faq', ['route' => 'bitbag_sylius_cms_plugin_admin_frequently_asked_question_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.faq')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'help')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('sections', ['route' => 'bitbag_sylius_cms_plugin_admin_section_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag_sylius_cms_plugin.ui.sections')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'grid layout')->shouldBeCalled();

        $this->buildMenu($menuBuilderEvent);
    }
}
