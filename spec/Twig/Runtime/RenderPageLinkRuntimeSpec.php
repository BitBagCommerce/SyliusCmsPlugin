<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Twig\Runtime;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderPageLinkRuntime;
use Sylius\CmsPlugin\Twig\Runtime\RenderPageLinkRuntimeInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RenderPageLinkRuntimeSpec extends ObjectBehavior
{
    public function let(
        PageRepositoryInterface $pageRepository,
        RouterInterface $router,
    ): void {
        $this->beConstructedWith($pageRepository, $router, 'defaultTemplate');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderPageLinkRuntime::class);
    }

    public function it_implements_render_link_runtime_interface(): void
    {
        $this->shouldHaveType(RenderPageLinkRuntimeInterface::class);
    }

    public function it_renders_link_for_code(
        Environment $environment,
        PageInterface $page,
        PageRepositoryInterface $pageRepository,
    ): void {
        $options = [];
        $code = 'CODE';
        $template = null;

        $pageRepository->findOneEnabledByCode($code)->willReturn($page);

        $environment->render($template ?? 'defaultTemplate', [
            'page' => $page,
            'options' => $options,
        ])->willReturn('link');

        $this->renderLinkForCode($environment, $code, $options, $template)->shouldReturn('link');
    }

    public function it_gets_link_for_code(
        RouterInterface $router,
        PageRepositoryInterface $pageRepository,
        PageInterface $page,
    ): void {
        $code = 'CODE';
        $slug = 'SLUG';
        $options = [];

        $pageRepository->findOneEnabledByCode($code)->willReturn($page);
        $page->getSlug()->willReturn($slug);

        $router->generate('sylius_cms_shop_page_show', ['slug' => $slug])->willReturn('link');

        $this->getLinkForCode($code, $options)->shouldReturn('link');
    }

    public function it_returns_not_found_message_when_getting_link_for_code(
        LocaleContextInterface $localeContext,
    ): void {
        $localeContext->getLocaleCode()->willReturn('en_US');

        $this->shouldThrow(NotFoundHttpException::class)->during('getLinkForCode', ['CODE']);
    }
}
