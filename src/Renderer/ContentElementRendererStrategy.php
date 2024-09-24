<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Twig\Parser\ContentParserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class ContentElementRendererStrategy implements ContentElementRendererStrategyInterface
{
    /**
     * @param ContentElementRendererInterface[] $renderers
     */
    public function __construct(
        private ContentParserInterface $contentParser,
        private LocaleContextInterface $localeContext,
        private iterable $renderers,
    ) {
    }

    public function render(BlockInterface|PageInterface $item): string
    {
        $content = '';

        foreach ($item->getContentElements() as $contentElement) {
            if ($contentElement->getLocale() !== $this->localeContext->getLocaleCode()) {
                continue;
            }

            foreach ($this->renderers as $renderer) {
                if ($renderer->supports($contentElement)) {
                    $content .= html_entity_decode($renderer->render($contentElement), \ENT_QUOTES);

                    break;
                }
            }
        }

        return $this->contentParser->parse($content);
    }
}
