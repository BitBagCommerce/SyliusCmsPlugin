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

final class MediaFixture extends AbstractFixture
{
    public function __construct(private FixtureFactoryInterface $mediaFixtureFactory)
    {
    }

    public function load(array $options): void
    {
        $this->mediaFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'media';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->integerNode('number')->defaultNull()->end()
                            ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('path')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('original_name')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('name')->defaultNull()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('productCodes')->scalarPrototype()->end()->end()
                            ->arrayNode('collections')->scalarPrototype()->end()->end()
                            ->arrayNode('channels')->scalarPrototype()->end()->end()
                            ->arrayNode('translations')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('content')->defaultNull()->end()
                                        ->scalarNode('alt')->defaultNull()->end()
                                        ->scalarNode('link')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
