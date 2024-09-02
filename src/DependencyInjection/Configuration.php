<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\CmsPlugin\Controller\BlockController;
use Sylius\CmsPlugin\Controller\MediaController;
use Sylius\CmsPlugin\Controller\PageController;
use Sylius\CmsPlugin\Entity\Block;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\Collection;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\ContentConfiguration;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\Media;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Entity\MediaTranslation;
use Sylius\CmsPlugin\Entity\MediaTranslationInterface;
use Sylius\CmsPlugin\Entity\Page;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Entity\PageTranslation;
use Sylius\CmsPlugin\Entity\PageTranslationInterface;
use Sylius\CmsPlugin\Entity\Template;
use Sylius\CmsPlugin\Entity\TemplateInterface;
use Sylius\CmsPlugin\Form\Type\BlockType;
use Sylius\CmsPlugin\Form\Type\CollectionType;
use Sylius\CmsPlugin\Form\Type\ContentConfigurationType;
use Sylius\CmsPlugin\Form\Type\MediaType;
use Sylius\CmsPlugin\Form\Type\PageType;
use Sylius\CmsPlugin\Form\Type\TemplateType;
use Sylius\CmsPlugin\Repository\BlockRepository;
use Sylius\CmsPlugin\Repository\CollectionRepository;
use Sylius\CmsPlugin\Repository\ContentConfigurationRepository;
use Sylius\CmsPlugin\Repository\MediaRepository;
use Sylius\CmsPlugin\Repository\PageRepository;
use Sylius\CmsPlugin\Repository\TemplateRepository;
use Sylius\Component\Resource\Factory\Factory;
use Sylius\Component\Resource\Factory\TranslatableFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sylius_cms');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('block')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Block::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(BlockInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(BlockController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(BlockRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(BlockType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('collection')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Collection::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(CollectionInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(CollectionRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(CollectionType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('content_configuration')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(ContentConfiguration::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(ContentConfigurationInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(ContentConfigurationRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(ContentConfigurationType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('media')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Media::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(MediaInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(MediaController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(TranslatableFactory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(MediaRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(MediaType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('classes')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('model')->defaultValue(MediaTranslation::class)->cannotBeEmpty()->end()
                                                ->scalarNode('interface')->defaultValue(MediaTranslationInterface::class)->cannotBeEmpty()->end()
                                                ->scalarNode('factory')->defaultValue(TranslatableFactory::class)->cannotBeEmpty()->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('page')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Page::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(PageInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(PageController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(TranslatableFactory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(PageRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(PageType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('classes')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('model')->defaultValue(PageTranslation::class)->cannotBeEmpty()->end()
                                                ->scalarNode('interface')->defaultValue(PageTranslationInterface::class)->cannotBeEmpty()->end()
                                                ->scalarNode('factory')->defaultValue(TranslatableFactory::class)->cannotBeEmpty()->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Template::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(TemplateInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(TemplateRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(TemplateType::class)->cannotBeEmpty()->end()
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
