<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Twig\Environment;

final class RenderBlockRuntime implements RenderBlockRuntimeInterface
{
    private const DEFAULT_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig';

    public function __construct(
        private BlockResourceResolverInterface $blockResourceResolver,
        private Environment $templatingEngine,
        private ContentElementRendererStrategyInterface $contentElementRendererStrategy,
    ) {
    }

    public function renderBlock(string $code, ?string $template = null, ProductInterface|TaxonInterface $context = null): string
    {
        $block = $this->blockResourceResolver->findOrLog($code);
        if (null === $block) {
            return '';
        }

        if ($context instanceof TaxonInterface && false === $block->canBeDisplayedForTaxon($context)) {
            return '';
        }

        if ($context instanceof ProductInterface &&
            false === $block->canBeDisplayedForProduct($context) &&
            false === $block->canBeDisplayedForProductInTaxon($context)
        ) {
            return '';
        }

        return $this->templatingEngine->render(
            $template ?? self::DEFAULT_TEMPLATE,
            [
                'content' => $this->contentElementRendererStrategy->render($block),
            ],
        );
    }
}
