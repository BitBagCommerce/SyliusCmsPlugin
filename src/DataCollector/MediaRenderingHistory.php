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

final class MediaRenderingHistory implements MediaRenderingHistoryInterface
{
    /** @var array */
    private $currentlyRendered = [];

    public function startRendering(MediaInterface $media): void
    {
        $this->currentlyRendered[] = $media;
    }

    public function getRenderedHistory(): array
    {
        return $this->currentlyRendered;
    }

    public function reset(): void
    {
        $this->currentlyRendered = [];
    }
}
