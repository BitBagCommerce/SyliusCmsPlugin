<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\DataCollector;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use PhpSpec\ObjectBehavior;

final class PageRenderingEventRecorderSpec extends ObjectBehavior
{
    public function it_start_rendering(
        PageInterface $page
    ) {
        $this->recordRenderingPageEvent($page)
            ->shouldReturn(null);
    }

    public function it_starts_multirendering_and_returns_data(
        PageInterface $page
    ) {
        $this->recordRenderingPageEvent($page)
            ->shouldReturn(null);

        $this->getRecordedEvents()
            ->shouldReturn([$page]);
    }

    public function it_starts_multirendering_and_returns_data(
        PageInterface $page
    ) {
        $this->recordRenderingPageEventMultiple([$page])
            ->shouldReturn(null);

        $this->getRecordedEvents()
            ->shouldReturn([$page]);
    }

    public function it_starts_rendering_and_clears_data(
        PageInterface $page
    ) {
        $this->recordRenderingPageEvent($page)
            ->shouldReturn(null);

        $this->reset()
            ->shouldReturn(null);

        $this->getRecordedEvents()
            ->shouldReturn([]);
    }
}
