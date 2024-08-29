<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Resolver\BlockResourceResolverInterface;
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

    public function renderBlock(string $code, ?string $template = null, ProductInterface|TaxonInterface|array $context = null): string
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
                'context' => $context,
            ],
        );
    }
}
