<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer;

use Sylius\CmsPlugin\Entity\PageInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class PageLinkRenderer implements PageLinkRendererInterface
{
    private const DEFAULT_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Page/link.html.twig';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private Environment $twig,
    ) {
    }

    public function render(PageInterface $page, ?string $template = null): string
    {
        return $this->twig->render(
            $template ?? self::DEFAULT_TEMPLATE,
            [
                'link' => $this->urlGenerator->generate(
                    'sylius_cms_plugin_shop_page_show',
                    ['slug' => $page->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL,
                ),
                'name' => $page->getName(),
            ],
        );
    }
}
