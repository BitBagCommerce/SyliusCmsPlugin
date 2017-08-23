<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

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
    public function createListQueryBuilder();

    /**
     * @param ChannelInterface $channel
     * @param string $locale
     * @param string $slug
     *
     * @return PageInterface|null
     */
    public function findOneByChannelAndSlug(ChannelInterface $channel, $locale, $slug);
}