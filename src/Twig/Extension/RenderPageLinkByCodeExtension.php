<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Twig\Extension;

use BitBag\CmsPlugin\Entity\PageInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class RenderPageLinkByCodeExtension extends \Twig_Extension
{
    const PAGE_LINK_TEMPLATE = 'BitBagCmsPlugin:Shop:Page:_link.html.twig';

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        LoggerInterface $logger
    )
    {
        $this->pageRepository = $pageRepository;
        $this->logger = $logger;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('bitbag_render_page_link_by_code', [$this, 'renderPageLinkByCode'], ['needs_environment' => true, 'is_safe' => ['html'],]),
        ];
    }

    /**
     * @param \Twig_Environment $twigEnvironment
     * @param string $code
     *
     * @return null|string
     */
    public function renderPageLinkByCode(\Twig_Environment $twigEnvironment, $code)
    {
        $page = $this->pageRepository->findEnabledByCode($code);

        if (false === $page instanceof PageInterface) {

            $this->logger->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $twigEnvironment->render(self::PAGE_LINK_TEMPLATE, ['page' => $page]);
    }
}
