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
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use PhpSpec\ObjectBehavior;

class PageRenderingEventRecorderSpec extends ObjectBehavior
{
    function it_start_render(
        PageInterface $page
    ) {
        $this->recordRenderingPageEvent($page);
    }

    function it_start_render_and_return_data(
        PageInterface $page
    ) {
        $this->recordRenderingPageEvent($page);

        $this->getRecordedEvents()
            ->shouldReturn([$page]);
    }

    function it_start_multi_render_and_return_data(
        PageInterface $page
    ) {
        $this->recordRenderingPageEventMultiple([$page]);

        $this->getRecordedEvents()
            ->shouldReturn([$page]);
    }

    function it_start_render_and_clear_data(
        PageInterface $page
    ) {
        $this->recordRenderingPageEvent($page);

        $this->reset();

        $this->getRecordedEvents()
            ->shouldReturn([]);
    }
}