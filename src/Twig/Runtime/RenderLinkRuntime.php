<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RenderLinkRuntime implements RenderLinkRuntimeInterface
{
    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var RouterInterface */
    private $router;

    /** @var string */
    private $defaultTemplate;

    public function __construct(
        LocaleContextInterface $localeContext,
        PageRepositoryInterface $pageRepository,
        RouterInterface $router,
        string $defaultTemplate
    ) {
        $this->localeContext = $localeContext;
        $this->pageRepository = $pageRepository;
        $this->router = $router;
        $this->defaultTemplate = $defaultTemplate;
    }

    public function renderLinkForCode(
        Environment $environment,
        string $code,
        array $options = [],
        ?string $template = null
    ): string {
        $page = $this->pageRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());

        return $environment->render($template ?? $this->defaultTemplate, [
            'page' => $page,
            'options' => $options,
        ]);
    }

    public function getLinkForCode(
        string $code,
        array $options = []
    ): string {
        $page = $this->pageRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());
        if (!$page) {
            return isset($options['notFoundMessage']) ? $options['notFoundMessage'] : '';
        }

        return $this->router->generate('bitbag_sylius_cms_plugin_shop_page_show', ['slug' => $page->getSlug()]);
    }
}
