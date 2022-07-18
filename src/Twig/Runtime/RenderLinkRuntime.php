<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use BitBag\SyliusCmsPlugin\DataCollector\PageRenderingEventRecorderInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    /** @var PageRenderingEventRecorderInterface */
    private $pageRenderingHistory;

    public function __construct(
        LocaleContextInterface $localeContext,
        PageRepositoryInterface $pageRepository,
        RouterInterface $router,
        PageRenderingEventRecorderInterface $pageRenderingHistory,
        string $defaultTemplate
    ) {
        $this->localeContext = $localeContext;
        $this->pageRepository = $pageRepository;
        $this->router = $router;
        $this->defaultTemplate = $defaultTemplate;
        $this->pageRenderingHistory = $pageRenderingHistory;
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
        /** @var PageInterface|null $page */
        $page = $this->pageRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());
        if (null === $page) {
            throw new NotFoundHttpException('Page for code "' . $code . '" not found');
        }
        $this->pageRenderingHistory->recordRenderingPageEvent($page);

        return $this->router->generate('bitbag_sylius_cms_plugin_shop_page_show', ['slug' => $page->getSlug()]);
    }
}
