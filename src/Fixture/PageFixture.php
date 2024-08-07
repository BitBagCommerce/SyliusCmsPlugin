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

final class PageFixture extends AbstractFixture
{
    public function __construct(private FixtureFactoryInterface $pageFixtureFactory)
    {
    }

    public function load(array $options): void
    {
        $this->pageFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'page';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->scalarNode('name')->end()
                            ->arrayNode('collections')->scalarPrototype()->end()->end()
                            ->arrayNode('channels')->scalarPrototype()->end()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('slug')->defaultNull()->end()
                                        ->scalarNode('meta_title')->defaultNull()->end()
                                        ->scalarNode('meta_keywords')->defaultNull()->end()
                                        ->scalarNode('meta_description')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('content_elements')
                                ->useAttributeAsKey('key') // Use keys from YAML as node names
                                    ->arrayPrototype()
                                        ->children()
                                            ->scalarNode('type')->end() // "type" field at the top level of each content element
                                            ->arrayNode('data') // "data" field containing the actual data
                                                ->children()
                                                    ->scalarNode('heading_type')->end()
                                                    ->scalarNode('heading')->end()
                                                    ->scalarNode('textarea')->end()
                                                    ->scalarNode('single_media')->end()
                                                    ->scalarNode('products_carousel_by_taxon')->end()
                                                    ->scalarNode('products_grid_by_taxon')->end()
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
                                        ->end() // End of data
                                    ->end()
                                ->end() // End of each content element
                            ->end() // End of content_elements array
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
