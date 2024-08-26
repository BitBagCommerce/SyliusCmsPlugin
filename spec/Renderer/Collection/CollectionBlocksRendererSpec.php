<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Renderer\Collection\CollectionBlocksRenderer;
use Sylius\CmsPlugin\Renderer\Collection\CollectionRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;

final class CollectionBlocksRendererSpec extends ObjectBehavior
{
    public function let(ContentElementRendererStrategyInterface $contentElementRendererStrategy): void
    {
        $this->beConstructedWith($contentElementRendererStrategy);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectionBlocksRenderer::class);
    }

    public function it_implements_collection_renderer_interface(): void
    {
        $this->shouldImplement(CollectionRendererInterface::class);
    }

    public function it_renders_blocks_from_collection(
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
        CollectionInterface $collection,
        BlockInterface $block1,
        BlockInterface $block2,
    ): void {
        $blocks = new ArrayCollection([$block1->getWrappedObject(), $block2->getWrappedObject()]);
        $collection->getBlocks()->willReturn($blocks);

        $contentElementRendererStrategy->render($block1)->willReturn('block1_content');
        $contentElementRendererStrategy->render($block2)->willReturn('block2_content');

        $this->render($collection)->shouldReturn('block1_contentblock2_content');
    }

    public function it_limits_number_of_rendered_blocks(
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
        CollectionInterface $collection,
        BlockInterface $block1,
        BlockInterface $block2,
    ): void {
        $blocks = new ArrayCollection([$block1->getWrappedObject(), $block2->getWrappedObject()]);
        $collection->getBlocks()->willReturn($blocks);

        $contentElementRendererStrategy->render($block1)->willReturn('block1_content');
        $contentElementRendererStrategy->render($block2)->willReturn('block2_content');

        $this->render($collection, 1)->shouldReturn('block1_content');
    }

    public function it_supports_collections_with_blocks(
        CollectionInterface $collection,
        BlockInterface $block,
    ): void {
        $blocks = new ArrayCollection([$block]);
        $collection->getBlocks()->willReturn($blocks);

        $this->supports($collection)->shouldReturn(true);
    }

    public function it_does_not_support_empty_collections(
        CollectionInterface $collection,
    ): void {
        $collection->getBlocks()->willReturn(new ArrayCollection());

        $this->supports($collection)->shouldReturn(false);
    }

    public function it_throws_exception_when_blocks_are_null(
        ContentElementRendererStrategyInterface $contentElementRendererStrategy,
        CollectionInterface $collection,
    ): void {
        $collection->getBlocks()->willReturn(null);

        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('render', [$collection]);
    }
}
