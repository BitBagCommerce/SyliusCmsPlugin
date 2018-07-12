<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Entity\PageContentInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Twig\Extension\RenderProductPagesExtension;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

final class RenderProductPagesExtensionSpec extends ObjectBehavior
{
    function let(
        PageRepositoryInterface $pageRepository,
        ChannelContextInterface $channelContext,
        EngineInterface $templatingEngine
    ): void {
        $this->beConstructedWith($pageRepository, $channelContext, $templatingEngine);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderProductPagesExtension::class);
    }

    function it_extends_twig_extension(): void
    {
        $this->shouldHaveType(\Twig_Extension::class);
    }

    function it_returns_functions(): void
    {
        $functions = $this->getFunctions();

        $functions->shouldHaveCount(1);

        foreach ($functions as $function) {
            $function->shouldHaveType(\Twig_SimpleFunction::class);
        }
    }

    function it_renders_product_pages(
        ChannelContextInterface $channelContext,
        ProductInterface $product,
        ChannelInterface $channel,
        PageRepositoryInterface $pageRepository,
        PageContentInterface $page,
        SectionInterface $section,
        EngineInterface $templatingEngine
    ): void {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $page->getSections()->willReturn(new ArrayCollection([$section]));
        $pageRepository->findByProduct($product, 'WEB')->willReturn([])->shouldBeCalled();
        $templatingEngine->render('@BitBagSyliusCmsPlugin/Shop/Product/_pagesBySection.html.twig', ['data' => []])->willReturn('content');

        $this->renderProductPages($product)->shouldReturn('content');
    }
}
