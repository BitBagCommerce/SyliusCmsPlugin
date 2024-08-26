<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
