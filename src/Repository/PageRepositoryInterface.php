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
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $locale
     *
     * @return QueryBuilder
     */
    public function createListQueryBuilder(string $locale): QueryBuilder;

    /**
     * @param string $code
     * @param string|null $localeCode
     *
     * @return PageInterface|null
     */
    public function findOneEnabledByCode(string $code, ?string $localeCode): ?PageInterface;

    /**
     * @param string $slug
     * @param null|string $localeCode
     * @param string $channelCode
     *
     * @return PageInterface|null
     */
    public function findOneEnabledBySlugAndChannelCode(string $slug, ?string $localeCode, string $channelCode): ?PageInterface;

    /**
     * @param string $sectionCode
     * @param string $channelCode
     *
     * @return QueryBuilder
     */
    public function createShopListQueryBuilder(string $sectionCode, string $channelCode): QueryBuilder;
}
