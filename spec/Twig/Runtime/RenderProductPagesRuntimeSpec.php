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

use BitBag\SyliusCmsPlugin\DataCollector\PageRenderingEventRecorderInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Sorter\SectionsSorterInterface;
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
        SectionsSorterInterface $sectionsSorter,
        PageRenderingEventRecorderInterface $pageRenderingEventRecorder
    ): void {
        $this->beConstructedWith($pageRepository, $channelContext, $templatingEngine, $sectionsSorter, $pageRenderingEventRecorder);
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
        SectionInterface $section,
        Environment $templatingEngine,
        SectionsSorterInterface $sectionsSorter,
        PageRenderingEventRecorderInterface $pageRenderingEventRecorder
    ): void {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);

        $page->getSections()->willReturn(new ArrayCollection([$section]));
        $section->getCode()->willReturn('SECTION_CODE');
        $pageRepository->findByProduct($product, 'WEB', null)->willReturn([])->shouldBeCalled();

        $pageRenderingEventRecorder->recordRenderingPageEventMultiple([]);
        $sectionsSorter->sortBySections([])->willReturn([]);

        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', ['data' => []])->willReturn('content');

        $this->renderProductPages($product)->shouldReturn('content');
    }

    public function it_renders_product_pages_with_sections(
        ChannelContextInterface $channelContext,
        ProductInterface $product,
        ChannelInterface $channel,
        PageRepositoryInterface $pageRepository,
        PageInterface $page,
        SectionInterface $section,
        Environment $templatingEngine,
        SectionsSorterInterface $sectionsSorter
    ): void {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $page->getSections()->willReturn(new ArrayCollection([$section]));
        $section->getCode()->willReturn('SECTION_CODE');
        $pageRepository->findByProductAndSectionCode($product, 'SECTION_CODE', 'WEB', null)->willReturn([])->shouldBeCalled();
        $sectionsSorter->sortBySections([])->willReturn([]);
        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', ['data' => []])->willReturn('content');

        $this->renderProductPages($product, 'SECTION_CODE')->shouldReturn('content');
    }
}
