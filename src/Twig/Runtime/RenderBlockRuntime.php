<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use Symfony\Component\Templating\EngineInterface;

final class RenderBlockRuntime implements RenderBlockRuntimeInterface
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var BlockResourceResolverInterface */
    private $blockResourceResolver;

    /** @var EngineInterface */
    private $templatingEngine;

    private const DEFAULT_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig';

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockResourceResolverInterface $blockResourceResolver,
        EngineInterface $templatingEngine
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockResourceResolver = $blockResourceResolver;
        $this->templatingEngine = $templatingEngine;
    }

    public function renderBlock(string $code, ?string $template = null): string
    {
        $block = $this->blockResourceResolver->findOrLog($code);

        if (null !== $block) {
            $template = $template ?? self::DEFAULT_TEMPLATE;

            return $this->templatingEngine->render($template, ['block' => $block]);
        }

        return '';
    }
}
