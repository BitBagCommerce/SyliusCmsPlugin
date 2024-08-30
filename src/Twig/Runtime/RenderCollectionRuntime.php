<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Sylius\CmsPlugin\Renderer\CollectionRendererStrategyInterface;
use Sylius\CmsPlugin\Resolver\CollectionResourceResolverInterface;
use Twig\Environment;

final class RenderCollectionRuntime implements RenderCollectionRuntimeInterface
{
    private const DEFAULT_TEMPLATE = '@SyliusCmsPlugin/Shop/Collection/show.html.twig';

    public function __construct(
        private Environment $twig,
        private CollectionResourceResolverInterface $collectionResourceResolver,
        private CollectionRendererStrategyInterface $collectionRenderer,
    ) {
    }

    public function renderCollection(string $code, ?int $countToRender = null, ?string $template = null): string
    {
        $collection = $this->collectionResourceResolver->findOrLog($code);
        if (null === $collection) {
            return '';
        }

        return $this->twig->render(
            $template ?? self::DEFAULT_TEMPLATE,
            [
                'content' => $this->collectionRenderer->render($collection, $countToRender),
            ],
        );
    }
}
