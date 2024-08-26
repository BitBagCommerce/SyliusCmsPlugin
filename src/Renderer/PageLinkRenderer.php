<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
                    'bitbag_sylius_cms_plugin_shop_page_show',
                    ['slug' => $page->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL,
                ),
                'name' => $page->getName(),
            ],
        );
    }
}
