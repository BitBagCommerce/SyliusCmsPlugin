<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Fixture;

use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\CmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class BlockFixture extends AbstractFixture
{
    public function __construct(private FixtureFactoryInterface $blockFixtureFactory)
    {
    }

    public function load(array $options): void
    {
        $this->blockFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'block';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->scalarNode('name')->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('collections')->scalarPrototype()->end()->end()
                            ->arrayNode('channels')->scalarPrototype()->end()->end()
                            ->arrayNode('locales')->scalarPrototype()->end()->end()
                            ->arrayNode('products')->scalarPrototype()->end()->end()
                            ->arrayNode('taxons')->scalarPrototype()->end()->end()
                            ->arrayNode('products_in_taxons')->scalarPrototype()->end()->end()
                            ->arrayNode('content_elements')
                                ->useAttributeAsKey('key')
                                    ->arrayPrototype()
                                        ->children()
                                            ->scalarNode('type')->end()
                                            ->arrayNode('data')
                                                ->children()
                                                    ->scalarNode('heading_type')->end()
                                                    ->scalarNode('heading')->end()
                                                    ->scalarNode('textarea')->end()
                                                    ->scalarNode('single_media')->end()
                                                    ->scalarNode('products_carousel_by_taxon')->end()
                                                    ->scalarNode('products_grid_by_taxon')->end()
                                                    ->scalarNode('pages_collection')->end()
                                                    ->scalarNode('pages_collection')->end()
                                                    ->scalarNode('spacer')->end()
                                                    ->arrayNode('multiple_media')->scalarPrototype()->end()->end()
                                                    ->arrayNode('products_grid')
                                                        ->children()
                                                            ->arrayNode('products')->scalarPrototype()->end()->end()
                                                        ->end()
                                                    ->end()
                                                    ->arrayNode('products_carousel')
                                                        ->children()
                                                            ->arrayNode('products')->scalarPrototype()->end()->end()
                                                        ->end()
                                                    ->end()
                                                    ->arrayNode('taxons_list')
                                                        ->children()
                                                            ->arrayNode('taxons')->scalarPrototype()->end()->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
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
