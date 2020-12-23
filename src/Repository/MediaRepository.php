<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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

    public function findOneEnabledByCode(string $code, string $channelCode): ?MediaInterface
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channel')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findBySectionCode(string $sectionCode, string $channelCode): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channel')
            ->innerJoin('o.sections', 'section')
            ->where('channel.code = :channelCode')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('channelCode', $channelCode)
            ->setParameter('sectionCode', $sectionCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProductCode(string $productCode, string $channelCode): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channel')
            ->innerJoin('o.products', 'product')
            ->where('channel.code = :channelCode')
            ->andWhere('product.code = :productCode')
            ->andWhere('o.enabled = true')
            ->setParameter('channelCode', $channelCode)
            ->setParameter('productCode', $productCode)
            ->getQuery()
            ->getResult()
        ;
    }
}
