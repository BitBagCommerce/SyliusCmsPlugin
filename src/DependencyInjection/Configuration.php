<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bitbag_sylius_cms_plugin');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->enumNode('wysiwyg_editor')
                    ->values(['trix', 'ckeditor'])
                    ->defaultValue('ckeditor')
        ;

        return $treeBuilder;
    }
}
