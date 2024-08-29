<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\CmsPlugin\Entity\CollectionInterface;

class CollectionRepository extends EntityRepository implements CollectionRepositoryInterface
{
    public function findByNamePart(string $phrase): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->setParameter('name', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNamePartAndType(string $phrase, string $type): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->andWhere('o.type = :type')
            ->setParameter('name', '%' . $phrase . '%')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByCode(string $code): ?CollectionInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByCodes(string $codes): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.code IN(:codes)')
            ->setParameter('codes', explode(',', $codes))
            ->getQuery()
            ->getResult()
        ;
    }
}
