<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface
{
    public function findEnabled(bool $enabled): array;

    public function findOneEnabledByCode(string $code): ?PageInterface;

    public function findOneEnabledBySlugAndChannelCode(
        string $slug,
        ?string $localeCode,
        string $channelCode,
    ): ?PageInterface;

    public function createShopListQueryBuilder(string $collectionCode, string $channelCode): QueryBuilder;

    public function findByCollectionCode(string $collectionCode): array;

    public function findByNamePart(string $phrase): array;
}
