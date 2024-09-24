<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class TemplateRepository extends EntityRepository implements TemplateRepositoryInterface
{
    public function findTemplatesByNamePart(string $phrase, string $type): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->andWhere('o.type = :type')
            ->setParameters([
                'name' => '%' . $phrase . '%',
                'type' => $type,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
