<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\CmsPlugin\Entity\MediaInterface;

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
        string $channelCode,
    ): ?MediaInterface {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channels')
            ->andWhere('o.code = :code')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('code', $code)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByNamePart(string $phrase, array $mediaType): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->andWhere('o.type IN (:mediaType)')
            ->setParameter('name', '%' . $phrase . '%')
            ->setParameter('mediaType', $mediaType)
            ->getQuery()
            ->getResult()
        ;
    }
}
