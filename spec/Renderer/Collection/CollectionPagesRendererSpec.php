<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\Collection\CollectionPagesRenderer;
use Sylius\CmsPlugin\Renderer\Collection\CollectionRendererInterface;
use Sylius\CmsPlugin\Renderer\PageLinkRendererInterface;

final class CollectionPagesRendererSpec extends ObjectBehavior
{
    public function let(PageLinkRendererInterface $pageLinkRenderer): void
    {
        $this->beConstructedWith($pageLinkRenderer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectionPagesRenderer::class);
    }

    public function it_implements_collection_renderer_interface(): void
    {
        $this->shouldImplement(CollectionRendererInterface::class);
    }

    public function it_renders_pages_from_collection(
        PageLinkRendererInterface $pageLinkRenderer,
        CollectionInterface $collection,
        PageInterface $page1,
        PageInterface $page2,
    ): void {
        $page1->getId()->willReturn(2);
        $page2->getId()->willReturn(1);

        $collection->getPages()->willReturn(new ArrayCollection([$page1->getWrappedObject(), $page2->getWrappedObject()]));

        $pageLinkRenderer->render($page1)->willReturn('page1_content');
        $pageLinkRenderer->render($page2)->willReturn('page2_content');

        $this->render($collection)->shouldReturn('page1_contentpage2_content');
    }

    public function it_limits_number_of_rendered_pages(
        PageLinkRendererInterface $pageLinkRenderer,
        CollectionInterface $collection,
        PageInterface $page1,
        PageInterface $page2,
    ): void {
        $page1->getId()->willReturn(2);
        $page2->getId()->willReturn(1);

        $collection->getPages()->willReturn(new ArrayCollection([$page1->getWrappedObject(), $page2->getWrappedObject()]));

        $pageLinkRenderer->render($page1)->willReturn('page1_content');
        $pageLinkRenderer->render($page2)->willReturn('page2_content');

        $this->render($collection, 1)->shouldReturn('page1_content');
    }

    public function it_supports_collections_with_pages(
        CollectionInterface $collection,
        PageInterface $page,
    ): void {
        $collection->getPages()->willReturn(new ArrayCollection([$page]));

        $this->supports($collection)->shouldReturn(true);
    }

    public function it_does_not_support_empty_collections(
        CollectionInterface $collection,
    ): void {
        $collection->getPages()->willReturn(new ArrayCollection());

        $this->supports($collection)->shouldReturn(false);
    }
}
