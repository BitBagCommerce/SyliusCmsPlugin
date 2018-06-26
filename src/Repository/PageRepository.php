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

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

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
        string $channelCode
    ): ?PageInterface
    {
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
}
