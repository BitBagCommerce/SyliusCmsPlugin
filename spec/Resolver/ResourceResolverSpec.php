<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Resolver\ResourceResolver;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ResourceResolverSpec extends ObjectBehavior
{
    public function let(
        RepositoryInterface $repository,
        FactoryInterface $factory,
    ) {
        $this->beConstructedWith($repository, $factory, 'unique_column');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResourceResolver::class);
    }

    public function it_returns_existing_resource_from_repository(
        RepositoryInterface $repository,
        ResourceInterface $resource,
    ) {
        $identifier = 'resource_identifier';

        $repository->findOneBy(['unique_column' => $identifier])->willReturn($resource);

        $this->getResource($identifier)->shouldReturn($resource);
    }

    public function it_creates_new_resource_using_factory(
        RepositoryInterface $repository,
        FactoryInterface $factory,
        ResourceInterface $newResource,
    ) {
        $identifier = 'resource_identifier';
        $factoryMethod = 'createNew';

        $repository->findOneBy(['unique_column' => $identifier])->willReturn(null);
        $factory->createNew()->willReturn($newResource);

        $this->getResource($identifier, $factoryMethod)->shouldReturn($newResource);
    }

    public function it_throws_exception_when_factory_method_not_callable(
        RepositoryInterface $repository,
        FactoryInterface $factory,
    ) {
        $identifier = 'resource_identifier';
        $factoryMethod = 'nonExistingMethod';

        $repository->findOneBy(['unique_column' => $identifier])->willReturn(null);

        $this->shouldThrow(\BadFunctionCallException::class)->during('getResource', [$identifier, $factoryMethod]);
    }
}
