<?php

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
