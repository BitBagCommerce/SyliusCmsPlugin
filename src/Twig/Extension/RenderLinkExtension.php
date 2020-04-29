<?php

/*
 * Created by Florian Merle - Dedi Agency <florian.merle@dedi-agency.com> <florian.david.merle@gmail.com>
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Routing\RouterInterface;

class RenderLinkExtension extends \Twig_Extension
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

    public function getFunctions()
    {
        return [
            new \Twig_Function('bitbag_cms_render_link_for_code', [$this, 'renderLinkForCode'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_Function('bitbag_cms_get_link_for_code', [$this, 'getLinkForCode']),
        ];
    }

    public function renderLinkForCode(
        \Twig_Environment $environment,
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
