<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\PageContentInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class PageResourceResolver implements PageResourceResolverInterface
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        LocaleContextInterface $localeContext,
        LoggerInterface $logger
    ) {
        $this->pageRepository = $pageRepository;
        $this->localeContext = $localeContext;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?PageContentInterface
    {
        $page = $this->pageRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());

        if (false === $page instanceof PageContentInterface) {
            $this->logger->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $page;
    }
}
