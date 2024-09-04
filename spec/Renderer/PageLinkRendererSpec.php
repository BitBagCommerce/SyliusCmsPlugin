<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Renderer\PageLinkRenderer;
use Sylius\CmsPlugin\Renderer\PageLinkRendererInterface;
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
            'sylius_cms_shop_page_show',
            ['slug' => 'page-slug'],
            UrlGeneratorInterface::ABSOLUTE_URL,
        )->willReturn('http://example.com/page-slug');

        $twig->render(
            '@SyliusCmsPlugin/Shop/Page/link.html.twig',
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
            'sylius_cms_shop_page_show',
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
