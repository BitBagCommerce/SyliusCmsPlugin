<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class CollectionFixture extends AbstractFixture
{
    public function __construct(private FixtureFactoryInterface $collectionFixtureFactory)
    {
    }

    public function load(array $options): void
    {
        $this->collectionFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'collection';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ?->node('name', 'scalar')->end()
                            ?->node('type', 'scalar')->end()
                            ?->arrayNode('page_codes')->scalarPrototype()->end()
                        ?->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
