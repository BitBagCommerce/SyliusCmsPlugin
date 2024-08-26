<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Renderer\Collection\CollectionRendererInterface;

final class CollectionRendererStrategy implements CollectionRendererStrategyInterface
{
    /**
     * @param CollectionRendererInterface[] $renderers
     */
    public function __construct(private iterable $renderers)
    {
    }

    public function render(CollectionInterface $collection, ?int $countToRender = null): string
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($collection)) {
                return $renderer->render($collection, $countToRender);
            }
        }

        return '';
    }
}
