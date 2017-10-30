<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Repository;

use BitBag\CmsPlugin\Entity\PageInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
interface PageRepositoryInterface extends RepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder(): QueryBuilder;

    /**
     * @param string $code
     *
     * @return null|PageInterface
     */
    public function findEnabledByCode(string $code): ?PageInterface;

    /**
     * @param ChannelInterface $channel
     * @param string $localeCode
     * @param string $slug
     *
     * @return null|PageInterface
     */
    public function findOneByChannelAndSlug(ChannelInterface $channel, string $localeCode, string $slug): ?PageInterface;
}
