<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Menu;

use BitBag\CmsPlugin\Menu\ContentManagementMenuBuilder;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ContentManagementMenuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContentManagementMenuBuilder::class);
    }

    function it_build_menu(
        MenuBuilderEvent $menuBuilderEvent,
        ItemInterface $menu,
        ItemInterface $cmsRootMenuItem
    )
    {
        $menuBuilderEvent->getMenu()->willReturn($menu);
        $menu->addChild('bitbag_cms')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabel('bitbag.cms.ui.cms')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem
            ->addChild('blocks', ['route' => 'bitbag_admin_block_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag.cms.ui.blocks')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'block layout')->shouldBeCalled();

        $cmsRootMenuItem
            ->addChild('pages', ['route' => 'bitbag_admin_page_index'])
            ->willReturn($cmsRootMenuItem)
        ;
        $cmsRootMenuItem->setLabel('bitbag.cms.ui.pages')->willReturn($cmsRootMenuItem);
        $cmsRootMenuItem->setLabelAttribute('icon', 'sticky note')->shouldBeCalled();

        $this->buildMenu($menuBuilderEvent);
    }
}
