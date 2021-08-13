<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
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

    public function findOrLog(string $code): ?PageInterface
    {
        $page = $this->pageRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());

        if (false === $page instanceof PageInterface) {
            $this->logger->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $page;
    }
}
