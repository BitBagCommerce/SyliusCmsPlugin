<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Renderer\CollectionRendererStrategyInterface;
use BitBag\SyliusCmsPlugin\Resolver\CollectionResourceResolverInterface;
use Twig\Environment;

final class RenderCollectionRuntime implements RenderCollectionRuntimeInterface
{
    private const DEFAULT_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Collection/show.html.twig';

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
