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

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BlockRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $localeCode
     *
     * @return QueryBuilder
     */
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    /**
     * @param string $code
     * @param string $channelCode
     *
     * @return BlockInterface|null
     */
    public function findOneEnabledByCodeAndChannelCode(string $code, string $channelCode): ?BlockInterface;

    /**
     * @param string $sectionCode
     * @param string $localeCode
     * @param string $channelCode
     *
     * @return BlockInterface[]
     */
    public function findBySectionCodeAndChannelCode(
        string $sectionCode,
        string $localeCode,
        string $channelCode
    ): array;

    /**
     * @param string $productCode
     * @param string $localeCode
     * @param string $channelCode
     *
     * @return array
     */
    public function findByProductCodeAndChannelCode(
        string $productCode,
        string $localeCode,
        string $channelCode
    ): array;
}
