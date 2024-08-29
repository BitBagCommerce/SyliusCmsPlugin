<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface MediaRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder;

    public function findOneEnabledByCode(
        string $code,
        string $localeCode,
        string $channelCode,
    ): ?MediaInterface;

    public function findByCollectionCode(
        string $collectionCode,
        string $localeCode,
        string $channelCode,
    ): array;

    public function findByProductCode(
        string $productCode,
        string $localeCode,
        string $channelCode,
    ): array;

    public function findByNamePart(string $phrase, array $mediaType): array;
}
