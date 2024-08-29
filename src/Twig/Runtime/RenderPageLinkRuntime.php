<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class RenderPageLinkRuntime implements RenderPageLinkRuntimeInterface
{
    public function __construct(
        private PageRepositoryInterface $pageRepository,
        private RouterInterface $router,
        private string $defaultTemplate,
    ) {
    }

    public function renderLinkForCode(
        Environment $environment,
        string $code,
        array $options = [],
        ?string $template = null,
    ): string {
        $page = $this->pageRepository->findOneEnabledByCode($code);

        return $environment->render($template ?? $this->defaultTemplate, [
            'page' => $page,
            'options' => $options,
        ]);
    }

    public function getLinkForCode(
        string $code,
        array $options = [],
    ): string {
        /** @var PageInterface|null $page */
        $page = $this->pageRepository->findOneEnabledByCode($code);
        if (null === $page) {
            throw new NotFoundHttpException('Page for code "' . $code . '" not found');
        }

        return $this->router->generate('sylius_cms_plugin_shop_page_show', ['slug' => $page->getSlug()]);
    }
}
