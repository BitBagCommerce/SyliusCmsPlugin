<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BadFunctionCallException;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ResourceResolver implements ResourceResolverInterface
{
    public function __construct(
        private RepositoryInterface $repository,
        private FactoryInterface $factory,
        private string $uniqueColumn,
    )
    {
    }

    /**
     * @throws BadFunctionCallException
     */
    public function getResource(string $identifier, string $factoryMethod = 'createNew'): ResourceInterface
    {
        /** @var ResourceInterface|null $resource */
        $resource = $this->repository->findOneBy([$this->uniqueColumn => $identifier]);
        if (null !== $resource) {
            return $resource;
        }
        $callback = [$this->factory, $factoryMethod];

        if (is_callable($callback) && method_exists($this->factory, $factoryMethod)) {
            return call_user_func($callback);
        }

        throw new BadFunctionCallException('Provided method' . $factoryMethod . ' is not callable');
    }
}
