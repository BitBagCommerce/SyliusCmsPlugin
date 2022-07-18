<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DataCollector;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;

final class PageRenderingEventRecorder implements PageRenderingEventRecorderInterface
{
    /** @var PageInterface[] */
    private $currentlyRendered = [];

    public function recordRenderingPageEvent(PageInterface $page): void
    {
        $this->currentlyRendered[] = $page;
    }

    public function recordRenderingPageEventMultiple(array $pages): void
    {
        $this->currentlyRendered = array_merge($this->currentlyRendered, $pages);
    }

    /** @return PageInterface[] */
    public function getRecordedEvents(): array
    {
        return $this->currentlyRendered;
    }

    public function reset(): void
    {
        $this->currentlyRendered = [];
    }
}
