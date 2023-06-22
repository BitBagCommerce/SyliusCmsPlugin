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
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderLinkRuntime;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderLinkRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RenderLinkRuntimeSpec extends ObjectBehavior
{
    public function let(
        LocaleContextInterface $localeContext,
        PageRepositoryInterface $pageRepository,
        RouterInterface $router
    ): void {
        $this->beConstructedWith($localeContext, $pageRepository, $router, 'defaultTemplate');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderLinkRuntime::class);
    }

    public function it_implements_render_link_runtime_interface(): void
    {
        $this->shouldHaveType(RenderLinkRuntimeInterface::class);
    }

    public function it_renders_link_for_code(
        Environment $environment,
        PageInterface $page,
        PageRepositoryInterface $pageRepository,
        LocaleContextInterface $localeContext
    ): void {
        $options = [];
        $code = 'CODE';
        $template = null;
        $localeCode = 'en_US';

        $localeContext->getLocaleCode()->willReturn($localeCode);
        $pageRepository->findOneEnabledByCode($code, $localeCode)->willReturn($page);

        $environment->render($template ?? 'defaultTemplate', [
            'page' => $page,
            'options' => $options,
        ])->willReturn('link');

        $this->renderLinkForCode($environment, $code, $options, $template)->shouldReturn('link');
    }

    public function it_gets_link_for_code(
        RouterInterface $router,
        LocaleContextInterface $localeContext,
        PageRepositoryInterface $pageRepository,
        PageInterface $page
    ): void {
        $code = 'CODE';
        $localeCode = 'en_US';
        $slug = 'SLUG';
        $options = [];

        $localeContext->getLocaleCode()->willReturn($localeCode);
        $pageRepository->findOneEnabledByCode($code, $localeCode)->willReturn($page);
        $page->getSlug()->willReturn($slug);

        $router->generate('bitbag_sylius_cms_plugin_shop_page_show', ['slug' => $slug])->willReturn('link');

        $this->getLinkForCode($code, $options)->shouldReturn('link');
    }

    public function it_returns_not_found_message_when_getting_link_for_code(
        LocaleContextInterface $localeContext
    ): void {
        $localeContext->getLocaleCode()->willReturn('en_US');

        $this->shouldThrow(NotFoundHttpException::class)->during('getLinkForCode', ['CODE']);
    }
}
