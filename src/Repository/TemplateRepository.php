<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

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
