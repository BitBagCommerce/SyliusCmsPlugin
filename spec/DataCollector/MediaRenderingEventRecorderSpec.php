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
use PhpSpec\ObjectBehavior;

class MediaRenderingEventRecorderSpec extends ObjectBehavior
{
    function it_start_render(
        MediaInterface $media
    ) {
        $this->recordRenderingMediaEvents($media);
    }

    function it_start_render_and_return_data(
        MediaInterface $media
    ) {
        $this->recordRenderingMediaEvents($media);

        $this->getRecordedEvents()
            ->shouldReturn([$media]);
    }

    function it_start_render_and_clear_data(
        MediaInterface $media
    ) {
        $this->recordRenderingMediaEvents($media);

        $this->reset();

        $this->getRecordedEvents()
            ->shouldReturn([]);
    }
}