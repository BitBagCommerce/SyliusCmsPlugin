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
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(string $localeCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation')
            ->where('translation.locale = :localeCode')
            ->setParameter('localeCode', $localeCode)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneEnabledByCodeAndChannelCode(string $code, string $channelCode): ?BlockInterface
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channels')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('code', $code)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySectionCodeAndChannelCode(
        string $sectionCode,
        string $localeCode,
        string $channelCode
    ): array {
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

    /**
     * {@inheritdoc}
     */
    public function findByProductCodeAndChannelCode(
        string $productCode,
        string $localeCode,
        string $channelCode
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
}
