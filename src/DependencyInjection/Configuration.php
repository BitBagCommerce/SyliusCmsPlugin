<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bitbag_sylius_cms');

        $this->addCmsResourcesSection($rootNode);

        return $treeBuilder;
    }

    private function addCmsResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('cms_resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('block')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('wysiwyg_editor')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('enabled')->defaultFalse()->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('page')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('wysiwyg_editor')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('enabled')->defaultFalse()->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('frequently_asked_question')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('wysiwyg_editor')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('enabled')->defaultFalse()->cannotBeEmpty()->end()
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
