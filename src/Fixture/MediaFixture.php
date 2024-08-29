<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Fixture;

use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\CmsPlugin\Fixture\Factory\FixtureFactoryInterface;
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
                            ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('path')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('original_name')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('name')->defaultNull()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
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
