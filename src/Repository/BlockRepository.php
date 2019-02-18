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

    public function findBySectionCode(string $sectionCode, string $localeCode, string $channelCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.sections', 'section')
            ->innerJoin('o.channels', 'channels')
            ->andWhere('translation.locale = :localeCode')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('sectionCode', $sectionCode)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProductCode(string $productCode, string $localeCode, string $channelCode): array
    {
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
}
