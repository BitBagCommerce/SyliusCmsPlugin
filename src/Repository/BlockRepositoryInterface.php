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
    public function createListQueryBuilder(): QueryBuilder;
    /**
     * @param string $code
     *
     * @return null|BlockInterface
     */
    public function findEnabledByCode(string $code): ?BlockInterface;
    /**
     * @param string $code
     * @param string $content
     *
     * @return null|BlockInterface
     */
    public function findEnabledByCodeAndContent(string $code, string $content): ?BlockInterface;
    /**
     * @param string $type
     * @param string $content
     *
     * @return null|BlockInterface
     */
    public function findOneByTypeAndContent(string $type, string $content): ?BlockInterface;
}