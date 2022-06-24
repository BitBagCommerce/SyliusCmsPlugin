<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DataCollector;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;

final class BlockRenderingHistory implements BlockRenderingHistoryInterface
{
    private array $currentlyRendered = [];

    public function startRenderingBlock(BlockInterface $block): void
    {
        $this->currentlyRendered[] = $block;
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