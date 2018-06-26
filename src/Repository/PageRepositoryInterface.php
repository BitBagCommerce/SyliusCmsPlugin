<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder;

    public function findByEnabled(bool $enabled): array;

    public function findOneEnabledByCode(string $code, ?string $localeCode): ?PageInterface;

    public function findOneEnabledBySlugAndChannelCode(
        string $slug,
        ?string $localeCode,
        string $channelCode
    ): ?PageInterface;

    public function createShopListQueryBuilder(string $sectionCode, string $channelCode): QueryBuilder;

    public function findByProduct(ProductInterface $product, string $channelCode): array;

    public function findByProductAndSectionCode(ProductInterface $product, string $sectionCode, string $channelCode): array;
}
