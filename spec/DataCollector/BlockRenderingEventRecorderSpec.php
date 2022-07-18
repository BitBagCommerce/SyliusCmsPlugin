<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\DataCollector;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use PhpSpec\ObjectBehavior;

final class BlockRenderingEventRecorderSpec extends ObjectBehavior
{
    function it_start_render(
        BlockInterface $block
    ) {
        $this->recordRenderingBlock($block)
            ->shouldReturn(null);
    }

    function it_starts_render_and_return_data(
        BlockInterface $block
    ) {
        $this->recordRenderingBlock($block)
            ->shouldReturn(null);

        $this->getRecordedEvents()
            ->shouldReturn([$block]);
    }

    function it_start_render_and_clear_data(
        BlockInterface $block
    ) {
        $this->recordRenderingBlock($block)
            ->shouldReturn(null);

        $this->reset()
            ->shouldReturn(null);

        $this->getRecordedEvents()
            ->shouldReturn([]);
    }
}
