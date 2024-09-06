<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\CmsPlugin\Entity\PageInterface;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    use TranslationBasedAwareTrait;

    public function findEnabled(bool $enabled): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('enabled', $enabled)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneEnabledByCode(string $code): ?PageInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneEnabledBySlugAndChannelCode(
        string $slug,
        ?string $localeCode,
        string $channelCode,
    ): ?PageInterface {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.channels', 'channels')
            ->where('translation.locale = :localeCode')
            ->andWhere('translation.slug = :slug')
            ->andWhere('channels.code = :channelCode')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('slug', $slug)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function createShopListQueryBuilder(string $collectionCode, string $channelCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.collections', 'collection')
            ->innerJoin('o.channels', 'channels')
            ->where('collection.code = :collectionCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('collectionCode', $collectionCode)
            ->setParameter('channelCode', $channelCode)
        ;
    }

    public function findByCollectionCode(string $collectionCode): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.collections', 'collection')
            ->andWhere('collection.code = :collectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('collectionCode', $collectionCode)
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
