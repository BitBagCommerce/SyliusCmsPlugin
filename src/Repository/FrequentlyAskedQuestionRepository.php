<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Repository;

use BitBag\CmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrequentlyAskedQuestionRepository extends EntityRepository implements FrequentlyAskedQuestionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findEnabledOrderedByPosition(string $localeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('translation.locale = :localeCode')
            ->andWhere('o.enabled = true')
            ->orderBy('o.position', 'DESC')
            ->setParameter('localeCode', $localeCode)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function findEnabledByCode(string $code): ?FrequentlyAskedQuestionInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
