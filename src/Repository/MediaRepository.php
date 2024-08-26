<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
