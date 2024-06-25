<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BlockRepository extends EntityRepository implements BlockRepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :localeCode')
            ->setParameter('localeCode', $localeCode)
        ;
    }

    public function findEnabledByCode(string $code, string $channelCode): ?BlockInterface
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.channels', 'channel')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->andWhere('channel.code = :channelCode')
            ->setParameter('code', $code)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByCollectionCode(
        string $collectionCode,
        string $channelCode,
    ): array {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.collections', 'collection')
            ->innerJoin('o.channels', 'channels')
            ->andWhere('collection.code = :collectionCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('collectionCode', $collectionCode)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNamePart(string $phrase): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->setParameter('name', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
