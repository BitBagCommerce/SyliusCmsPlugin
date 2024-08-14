<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Renderer;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Renderer\PageLinkRenderer;
use BitBag\SyliusCmsPlugin\Renderer\PageLinkRendererInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class PageLinkRendererSpec extends ObjectBehavior
{
    public function let(
        UrlGeneratorInterface $urlGenerator,
        Environment $twig,
    ): void {
        $this->beConstructedWith($urlGenerator, $twig);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PageLinkRenderer::class);
    }

    public function it_implements_page_link_renderer_interface(): void
    {
        $this->shouldImplement(PageLinkRendererInterface::class);
    }

    public function it_renders_page_link_with_default_template(
        UrlGeneratorInterface $urlGenerator,
        Environment $twig,
        PageInterface $page,
    ): void {
        $page->getSlug()->willReturn('page-slug');
        $page->getName()->willReturn('Page Name');

        $urlGenerator->generate(
            'bitbag_sylius_cms_plugin_shop_page_show',
            ['slug' => 'page-slug'],
            UrlGeneratorInterface::ABSOLUTE_URL,
        )->willReturn('http://example.com/page-slug');

        $twig->render(
            '@BitBagSyliusCmsPlugin/Shop/Page/link.html.twig',
            [
                'link' => 'http://example.com/page-slug',
                'name' => 'Page Name',
            ],
        )->willReturn('<a href="http://example.com/page-slug">Page Name</a>');

        $this->render($page)->shouldReturn('<a href="http://example.com/page-slug">Page Name</a>');
    }

    public function it_renders_page_link_with_custom_template(
        UrlGeneratorInterface $urlGenerator,
        Environment $twig,
        PageInterface $page,
    ): void {
        $page->getSlug()->willReturn('page-slug');
        $page->getName()->willReturn('Page Name');

        $urlGenerator->generate(
            'bitbag_sylius_cms_plugin_shop_page_show',
            ['slug' => 'page-slug'],
            UrlGeneratorInterface::ABSOLUTE_URL,
        )->willReturn('http://example.com/page-slug');

        $twig->render(
            'custom_template.html.twig',
            [
                'link' => 'http://example.com/page-slug',
                'name' => 'Page Name',
            ],
        )->willReturn('<a href="http://example.com/page-slug">Page Name</a>');

        $this->render($page, 'custom_template.html.twig')->shouldReturn('<a href="http://example.com/page-slug">Page Name</a>');
    }
}
