<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository implements MediaRepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->setParameter('locale', $locale)
        ;
    }

    public function findOneEnabledByCode(
        string $code,
        string $localeCode,
        string $channelCode,
    ): ?MediaInterface {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.channels', 'channels')
            ->where('translation.locale = :localeCode')
            ->andWhere('o.code = :code')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('code', $code)
            ->setParameter('localeCode', $localeCode)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByCollectionCode(
        string $collectionCode,
        string $localeCode,
        string $channelCode,
    ): array {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.collections', 'collection')
            ->innerJoin('o.channels', 'channels')
            ->andWhere('translation.locale = :localeCode')
            ->andWhere('collection.code = :collectionCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('collectionCode', $collectionCode)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProductCode(
        string $productCode,
        string $localeCode,
        string $channelCode,
    ): array {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.products', 'product')
            ->innerJoin('o.channels', 'channels')
            ->andWhere('translation.locale = :localeCode')
            ->andWhere('product.code = :productCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('productCode', $productCode)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNamePart(string $phrase, string $mediaType): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->andWhere('o.type = :mediaType')
            ->setParameter('name', '%' . $phrase . '%')
            ->setParameter('mediaType', $mediaType)
            ->getQuery()
            ->getResult()
        ;
    }
}
