<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;

final class CollectionResourceResolver implements CollectionResourceResolverInterface
{
    public function __construct(
        private CollectionRepositoryInterface $collectionRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function findOrLog(string $code): ?CollectionInterface
    {
        $collection = $this->collectionRepository->findOneByCode($code);

        if (false === $collection instanceof CollectionInterface) {
            $this->logger->warning(sprintf(
                'Collection with "%s" code was not found in the database.',
                $code,
            ));

            return null;
        }

        return $collection;
    }
}
