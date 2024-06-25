<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Sorter\CollectionsSorterInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderProductPagesRuntimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Twig\Environment;

final class RenderProductPagesRuntimeSpec extends ObjectBehavior
{
    public function let(
        PageRepositoryInterface $pageRepository,
        ChannelContextInterface $channelContext,
        Environment $templatingEngine,
        CollectionsSorterInterface $collectionsSorter
    ): void {
        $this->beConstructedWith($pageRepository, $channelContext, $templatingEngine, $collectionsSorter);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderProductPagesRuntime::class);
    }

    public function it_implements_render_product_pages_runtime_interface(): void
    {
        $this->shouldHaveType(RenderProductPagesRuntimeInterface::class);
    }

    public function it_renders_product_pages(
        ChannelContextInterface $channelContext,
        ProductInterface $product,
        ChannelInterface $channel,
        PageRepositoryInterface $pageRepository,
        PageInterface $page,
        CollectionInterface $collection,
        Environment $templatingEngine,
        CollectionsSorterInterface $collectionsSorter
    ): void {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $page->getCollections()->willReturn(new ArrayCollection([$collection]));
        $collection->getCode()->willReturn('COLLECTION_CODE');
        $pageRepository->findByProduct($product, 'WEB', null)->willReturn([])->shouldBeCalled();
        $collectionsSorter->sortByCollections([])->willReturn([]);
        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesByCollection.html.twig', ['data' => []])->willReturn('content');

        $this->renderProductPages($product)->shouldReturn('content');
    }

    public function it_renders_product_pages_with_collections(
        ChannelContextInterface $channelContext,
        ProductInterface $product,
        ChannelInterface $channel,
        PageRepositoryInterface $pageRepository,
        PageInterface $page,
        CollectionInterface $collection,
        Environment $templatingEngine,
        CollectionsSorterInterface $collectionsSorter
    ): void {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $page->getCollections()->willReturn(new ArrayCollection([$collection]));
        $collection->getCode()->willReturn('COLLECTION_CODE');
        $pageRepository->findByProductAndCollectionCode($product, 'COLLECTION_CODE', 'WEB', null)->willReturn([])->shouldBeCalled();
        $collectionsSorter->sortByCollections([])->willReturn([]);
        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesByCollection.html.twig', ['data' => []])->willReturn('content');

        $this->renderProductPages($product, 'COLLECTION_CODE')->shouldReturn('content');
    }
}
