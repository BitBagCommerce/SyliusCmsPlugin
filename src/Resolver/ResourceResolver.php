<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
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

    public function __construct(RepositoryInterface $repository, FactoryInterface $factory, string $uniqueColumn)
    {
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
