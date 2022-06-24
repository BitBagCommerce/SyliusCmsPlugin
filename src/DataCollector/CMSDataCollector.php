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
    /**
     * @var BlockRenderingHistoryInterface
     */
    private $blockRenderingHistory;

    /** @var MediaRenderingHistoryInterface */
    private $mediaRenderingHistory;

    /** @var PageRenderingHistoryInterface */
    private $pageRenderingHistory;

    public function __construct(
        BlockRenderingHistoryInterface $blockRenderingHistory,
        MediaRenderingHistoryInterface $mediaRenderingHistory,
        PageRenderingHistoryInterface $pageRenderingHistory
    )
    {
        $this->blockRenderingHistory = $blockRenderingHistory;
        $this->mediaRenderingHistory = $mediaRenderingHistory;
        $this->pageRenderingHistory = $pageRenderingHistory;
    }

    public function collect(Request $request, Response $response, \Throwable $exception = null): void
    {
        $this->data = [
            'media' => $this->mediaRenderingHistory->getRenderedHistory(),
            'block' => $this->blockRenderingHistory->getRenderedHistory(),
            'page' => $this->pageRenderingHistory->getRenderedHistory()
        ];
    }

    public static function getTemplate(): ?string
    {
        return "@BitBagSyliusCmsPlugin/CMSDataCollector/block_collector.html.twig";
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
