<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ResourceResolver implements ResourceResolverInterface
{
    /** @var RepositoryInterface */
    private $repository;

    /** @var FactoryInterface */
    private $factory;

    /** @var string */
    private $uniqueColumn;

    public function __construct(
        RepositoryInterface $repository,
        FactoryInterface $factory,
        string $uniqueColumn
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->uniqueColumn = $uniqueColumn;
    }

    public function getResource(string $identifier, string $factoryMethod = 'createNew'): ResourceInterface
    {
        /** @var ResourceInterface $resource */
        if ($resource = $this->repository->findOneBy([$this->uniqueColumn => $identifier])) {
            return $resource;
        }

        return $this->factory->$factoryMethod();
    }
}
