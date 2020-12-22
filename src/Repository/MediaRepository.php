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
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
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

    /**
     * {@inheritDoc}
     */
    public function findByPhrase(
        ?string $phrase,
        ?string $mediaType = null,
        int $limit = self::DEFAULT_LIMIT,
        int $page = self::DEFAULT_PAGE
    ): array {
        $qb = $this->createListQueryBuilder();
        $expr = $qb->expr();

        $qb->andWhere('o.enabled = true');

        if (null !== $phrase && strlen($phrase) > 0) {
            $qb
                ->andWhere($expr->orX(
                    $expr->like('o.code', ':phrase'),
                    $expr->like('translation.name', ':phrase')
                ))
                ->setParameter(
                    'phrase',
                    '%' . addcslashes((string)$phrase, "%_") . '%'
                )
            ;
        }

        if (null !== $mediaType) {
            $qb
                ->andWhere('o.type = :mediaType')
                ->setParameter('mediaType', $mediaType)
            ;
        }
        
        $qb->orderBy('o.code');

        $paginator = $this->getPaginator($qb);
        $paginator
            ->setMaxPerPage($limit > 0 ? $limit : self::DEFAULT_LIMIT)
            ->setCurrentPage($page > 0 ? $page : self::DEFAULT_PAGE)
        ;

        return (array) $paginator->getCurrentPageResults();
    }
}
