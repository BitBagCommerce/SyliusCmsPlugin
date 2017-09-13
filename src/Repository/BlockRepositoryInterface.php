<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Repository;

use BitBag\CmsPlugin\Entity\BlockInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
interface BlockRepositoryInterface extends RepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder();

    /**
     * @param string $code
     *
     * @return BlockInterface|null
     */
    public function findOneByCode($code);

    /**
     * @param string $code
     * @param string $content
     *
     * @return BlockInterface|null
     */
    public function findOneByCodeAndContent($code, $content);

    /**
     * @param string $type
     * @param string $content
     *
     * @return BlockInterface|null
     */
    public function findOneByTypeAndContent($type, $content);
}