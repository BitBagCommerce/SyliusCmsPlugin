<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    public function findEnabled(bool $enabled): array;

    public function findOneEnabledByCode(string $code, ?string $localeCode): ?PageInterface;

    public function findOneEnabledBySlugAndChannelCode(
        string $slug,
        ?string $localeCode,
        string $channelCode,
    ): ?PageInterface;

    public function createShopListQueryBuilder(string $sectionCode, string $channelCode): QueryBuilder;

    public function findBySectionCode(string $sectionCode, ?string $localeCode): array;

    public function findByProduct(
        ProductInterface $product,
        string $channelCode,
        ?\DateTimeInterface $date,
    ): array;

    public function findByProductAndSectionCode(
        ProductInterface $product,
        string $sectionCode,
        string $channelCode,
        ?\DateTimeInterface $date,
    ): array;

    public function findByNamePart(string $phrase, ?string $locale = null): array;
}
