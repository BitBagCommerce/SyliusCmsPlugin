<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DataCollector;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;

final class MediaRenderingEventRecorder implements MediaRenderingEventRecorderInterface
{
    /** @var array */
    private $recordedEvents = [];

    public function recordRenderingMediaEvents(MediaInterface $media): void
    {
        $this->recordedEvents[] = $media;
    }

    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function reset(): void
    {
        $this->recordedEvents = [];
    }
}
