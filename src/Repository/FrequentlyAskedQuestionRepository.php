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

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class FrequentlyAskedQuestionRepository extends EntityRepository implements FrequentlyAskedQuestionRepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation')
            ->where('translation.locale = :locale')
            ->setParameter('locale', $locale)
        ;
    }

    public function findEnabledOrderedByPositionAndChannelCode(string $localeCode, string $channelCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.channels', 'channels')
            ->where('translation.locale = :localeCode')
            ->andWhere('o.enabled = true')
            ->andWhere('channels.code = :channelCode')
            ->orderBy('o.position', 'ASC')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneEnabledByCode(string $code): ?FrequentlyAskedQuestionInterface
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
