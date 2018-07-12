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

use BitBag\SyliusCmsPlugin\Entity\PageContentInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ProductInterface;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation')
            ->where('translation.locale = :locale')
            ->setParameter('locale', $locale)
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

    public function findOneEnabledByCode(string $code, ?string $localeCode): ?PageContentInterface
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
        string $channelCode
    ): ?PageContentInterface {
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

    public function findByProduct(ProductInterface $product, string $channelCode): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.products', 'product')
            ->innerJoin('o.channels', 'channel')
            ->where('o.enabled = true')
            ->andWhere('product = :product')
            ->andWhere('channel.code = :channelCode')
            ->setParameter('product', $product)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProductAndSectionCode(
        ProductInterface $product,
        string $sectionCode,
        string $channelCode
    ): array {
        return $this->createQueryBuilder('o')
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
            ->getQuery()
            ->getResult()
        ;
    }
}
