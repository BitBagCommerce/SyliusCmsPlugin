<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector as Collector;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

class CMSDataCollector extends Collector implements DataCollectorInterface
{
    /** @var BlockRenderingEventRecorderInterface */
    private $blockRenderingHistory;

    /** @var MediaRenderingEventRecorderInterface */
    private $mediaRenderingHistory;

    /** @var PageRenderingEventRecorderInterface */
    private $pageRenderingHistory;

    public function __construct(
        BlockRenderingEventRecorderInterface $blockRenderingHistory,
        MediaRenderingEventRecorderInterface $mediaRenderingHistory,
        PageRenderingEventRecorderInterface $pageRenderingHistory
    ) {
        $this->blockRenderingHistory = $blockRenderingHistory;
        $this->mediaRenderingHistory = $mediaRenderingHistory;
        $this->pageRenderingHistory = $pageRenderingHistory;
    }

    public function collect(
        Request $request,
        Response $response,
        \Throwable $exception = null
    ): void {
        $this->data = [
            'media' => $this->mediaRenderingHistory->getRecordedEvents(),
            'block' => $this->blockRenderingHistory->getRecordedEvents(),
            'page' => $this->pageRenderingHistory->getRecordedEvents(),
        ];
    }

    public static function getTemplate(): ?string
    {
        return '@BitBagSyliusCmsPlugin/CMSDataCollector/block_collector.html.twig';
    }

    public function reset(): void
    {
        $this->data = [];
    }

    public function getMedia(): array
    {
        return $this->data['media'];
    }

    public function getBlock(): array
    {
        return $this->data['block'];
    }

    public function getPage(): array
    {
        return $this->data['page'];
    }

    public function getName(): string
    {
        return 'bitbag_sylius_cms_plugin.data_collector.cms';
    }
}
