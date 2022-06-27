<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\DataCollector\BlockRenderingHistory;
use BitBag\SyliusCmsPlugin\DataCollector\BlockRenderingHistoryInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use Twig\Environment;

final class RenderBlockRuntime implements RenderBlockRuntimeInterface
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var BlockResourceResolverInterface */
    private $blockResourceResolver;

    /** @var Environment */
    private $templatingEngine;

    private const DEFAULT_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig';

    /** @var BlockRenderingHistoryInterface */
    private $blockRenderingHistory;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockResourceResolverInterface $blockResourceResolver,
        Environment $templatingEngine,
        BlockRenderingHistoryInterface $blockRenderingHistory
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockResourceResolver = $blockResourceResolver;
        $this->templatingEngine = $templatingEngine;
        $this->blockRenderingHistory = $blockRenderingHistory;
    }

    public function renderBlock(string $code, ?string $template = null): string
    {
        $block = $this->blockResourceResolver->findOrLog($code);

        if (null !== $block) {
            $this->blockRenderingHistory->startRenderingBlock($block);

            $template = $template ?? self::DEFAULT_TEMPLATE;

            return $this->templatingEngine->render($template, ['block' => $block]);
        }

        return '';
    }
}
