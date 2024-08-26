<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface CollectionRepositoryInterface extends RepositoryInterface
{
    public function findByNamePart(string $phrase): array;

    public function findByNamePartAndType(string $phrase, string $type): array;

    public function findOneByCode(string $code): ?CollectionInterface;

    public function findByCodes(string $codes): array;
}
