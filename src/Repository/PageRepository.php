<?php

/**
 * This file has been created by the developers from BitBag.
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
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation')
            ->where('translation.locale = :locale')
            ->setParameter('locale', $locale)
        ;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function findOneEnabledBySlug(string $slug, ?string $localeCode): ?PageInterface
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('translation.locale = :localeCode')
            ->andWhere('translation.slug = :slug')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function createShopListQueryBuilder(string $sectionCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.sections', 'section')
            ->where('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('sectionCode', $sectionCode)
        ;
    }
}
