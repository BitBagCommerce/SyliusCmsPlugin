<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Strategy;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;

final class ContentElementRendererStrategy implements ContentElementRendererStrategyInterface
{
    /**
     * @param ContentElementRendererInterface[] $renderers
     */
    public function __construct(
        private ContentParserInterface $contentParser,
        private iterable $renderers,
    ) {
    }

    public function render(BlockInterface|PageInterface $item): string
    {
        $content = '';

        foreach ($item->getContentElements() as $contentElement) {
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
