<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;

final class PageResourceResolver implements PageResourceResolverInterface
{
    public function __construct(
        private PageRepositoryInterface $pageRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function findOrLog(string $code): ?PageInterface
    {
        $page = $this->pageRepository->findOneEnabledByCode($code);

        if (false === $page instanceof PageInterface) {
            $this->logger->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                $code,
            ));

            return null;
        }

        return $page;
    }
}
