<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
