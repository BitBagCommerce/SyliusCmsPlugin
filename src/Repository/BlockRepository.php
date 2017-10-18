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
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class BlockRepository extends EntityRepository implements BlockRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o');
    }

    /**
     * {@inheritdoc}
     */
    public function findEnabledByCode(string $code): ?BlockInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findEnabledByCodeAndContent(string $code, string $content): ?BlockInterface
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->andWhere('translation.content = :content')
            ->setParameter('code', $code)
            ->setParameter('content', $content)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByTypeAndContent(string $type, string $content): ?BlockInterface
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('o.type = :type')
            ->andWhere('o.enabled = true')
            ->andWhere('translation.content = :content')
            ->setParameter('type', $type)
            ->setParameter('content', $content)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
