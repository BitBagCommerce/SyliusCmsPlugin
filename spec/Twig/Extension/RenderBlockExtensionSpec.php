<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\CmsPlugin\Twig\Extension;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\CmsPlugin\Resolver\BlockResourceResolverInterface;
use BitBag\CmsPlugin\Resolver\BlockTemplateResolverInterface;
use BitBag\CmsPlugin\Twig\Extension\RenderBlockExtension;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class RenderBlockExtensionSpec extends ObjectBehavior
{
    function let(
        BlockRepositoryInterface $blockRepository,
        BlockTemplateResolverInterface $blockTemplateResolver,
        BlockResourceResolverInterface $blockResourceResolver
    ): void
    {
        $this->beConstructedWith($blockRepository, $blockTemplateResolver, $blockResourceResolver);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderBlockExtension::class);
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

    function it_renders_block(
        BlockResourceResolverInterface $blockResourceResolver,
        BlockTemplateResolverInterface $blockTemplateResolver,
        BlockInterface $block,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $blockResourceResolver->findOrLog('bitbag')->willReturn($block);
        $blockTemplateResolver->resolveTemplate($block)->willReturn('@BitBagCmsPlugin/Shop/Block/htmlBlock.html.twig');
        $twigEnvironment->render('@BitBagCmsPlugin/Shop/Block/htmlBlock.html.twig', ['block' => $block])->willReturn('<div>BitBag</div>');

        $this->renderBlock($twigEnvironment, 'bitbag');
    }
}

