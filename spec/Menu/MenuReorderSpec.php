<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Menu;

use BitBag\SyliusCmsPlugin\Menu\MenuReorder;
use BitBag\SyliusCmsPlugin\Menu\MenuReorderInterface;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class MenuReorderSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MenuReorder::class);
    }

    public function it_implements_menu_reorder_interface(): void
    {
        $this->shouldImplement(MenuReorderInterface::class);
    }

    public function it_reorders_menu_items(
        ItemInterface $menu,
        ItemInterface $item1,
        ItemInterface $item2,
        ItemInterface $item3
    ): void
    {
        $menu->getChildren()->willReturn([
            'item1' => $item1,
            'item2' => $item2,
            'item3' => $item3
        ]);

        $menu->getChild('item2')->willReturn($item2);

        $menu->setChildren([
            'item1' => $item1,
            'item3' => $item3,
            'item2' => $item2
        ])->shouldBeCalled();

        $this->reorder($menu, 'item2', 'item3');
    }

    public function it_does_not_reorder_if_new_item_is_not_found(
        ItemInterface $menu,
        ItemInterface $item1,
        ItemInterface $item3
    ): void
    {
        $menu->getChildren()->willReturn([
            'item1' => $item1,
            'item3' => $item3
        ]);

        $menu->getChild('item2')->willReturn(null);
        $menu->setChildren(Argument::any())->shouldNotBeCalled();

        $this->reorder($menu, 'item2', 'item3');
    }

    public function it_does_not_reorder_if_target_item_is_not_found(
        ItemInterface $menu,
        ItemInterface $item1,
        ItemInterface $item2
    ): void
    {
        $menu->getChildren()->willReturn([
            'item1' => $item1,
            'item2' => $item2
        ]);

        $menu->getChild('item1')->willReturn($item1);
        $menu->setChildren(Argument::any())->shouldNotBeCalled();

        $this->reorder($menu, 'item1', 'item3');
    }

    public function it_does_not_modify_menu_when_no_reorder_is_needed(
        ItemInterface $menu,
        ItemInterface $item1,
        ItemInterface $item2
    ): void
    {
        $menu->getChildren()->willReturn([
            'item1' => $item1,
            'item2' => $item2
        ]);

        $menu->getChild('item1')->willReturn($item1);
        $menu->getChild('item2')->willReturn($item2);
        $menu->setChildren(Argument::any())->shouldNotBeCalled();

        $this->reorder($menu, 'item1', 'item1');
    }
}
