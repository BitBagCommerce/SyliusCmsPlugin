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

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface MediaRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder;

    public function findOneEnabledByCode(string $code, string $localeCode): ?MediaInterface;

    public function findBySectionCode(string $sectionCode, ?string $localeCode): array;

    public function findByProductCode(string $productCode, string $channelCode, ?string $localeCode): array;
}
