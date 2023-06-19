<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ProductInterface;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :localeCode')
            ->leftJoin('o.sections', 'sections')
            ->setParameter('localeCode', $localeCode)
        ;
    }

    public function findEnabled(bool $enabled): array
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('enabled', $enabled)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneEnabledByCode(string $code, ?string $localeCode): ?PageInterface
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('translation.locale = :localeCode')
            ->andWhere('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->setParameter('localeCode', $localeCode)
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

    public function createShopListQueryBuilder(string $sectionCode, string $channelCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.sections', 'section')
            ->innerJoin('o.channels', 'channels')
            ->where('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->setParameter('sectionCode', $sectionCode)
            ->setParameter('channelCode', $channelCode)
        ;
    }

    public function findBySectionCode(string $sectionCode, ?string $localeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.sections', 'section')
            ->where('translation.locale = :localeCode')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('sectionCode', $sectionCode)
            ->setParameter('localeCode', $localeCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProduct(
        ProductInterface $product,
        string $channelCode,
        ?\DateTimeInterface $date = null,
    ): array {
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.products', 'product')
            ->innerJoin('o.channels', 'channel')
            ->where('o.enabled = true')
            ->andWhere('product = :product')
            ->andWhere('channel.code = :channelCode')
            ->setParameter('product', $product)
            ->setParameter('channelCode', $channelCode)
        ;

        if (null !== $date) {
            $this->addDateFilter($qb, $date);
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProductAndSectionCode(
        ProductInterface $product,
        string $sectionCode,
        string $channelCode,
        ?\DateTimeInterface $date = null,
    ): array {
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.products', 'product')
            ->innerJoin('o.sections', 'section')
            ->innerJoin('o.channels', 'channel')
            ->where('o.enabled = true')
            ->andWhere('product = :product')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('channel.code = :channelCode')
            ->setParameter('product', $product)
            ->setParameter('sectionCode', $sectionCode)
            ->setParameter('channelCode', $channelCode)
        ;

        if (null !== $date) {
            $this->addDateFilter($qb, $date);
        }

        return $qb->getQuery()
            ->getResult()
        ;
    }

    private function addDateFilter(QueryBuilder $qb, \DateTimeInterface $date): void
    {
        $qb
            ->andWhere(
                $qb->expr()->orX(
                    'o.publishAt is NULL',
                    'o.publishAt <= :date',
                ),
            )
            ->setParameter('date', $date)
        ;
    }
}
