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
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;

final class BlockFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $blockFixtureFactory;

    public function __construct(FixtureFactoryInterface $blockFixtureFactory)
    {
        $this->blockFixtureFactory = $blockFixtureFactory;
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
                            ->integerNode('number')->defaultNull()->end()
                            ->booleanNode('last_four_products')->defaultFalse()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->integerNode('products')->defaultNull()->end()
                            ->append($this->createArrayOfScalars('productCodes'))
                            ->append($this->createArrayOfScalars('taxons'))
                            ->append($this->createArrayOfScalars('sections'))
                            ->append($this->createArrayOfScalars('channels'))
                            ->append($this->translationsConfiguration())
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function createArrayOfScalars(string $name): NodeDefinition
    {
        $nodeDefinition = new ScalarNodeDefinition($name);
        $nodeDefinition->defaultNull()->end();
        return $nodeDefinition;
    }

    private function translationsConfiguration(): NodeDefinition
    {
        $translationsNodeDefinition = new ArrayNodeDefinition('translations');
        $translationsNodeDefinition
            ->arrayPrototype()
                ->children()
                    ->scalarNode('name')->end()
                    ->scalarNode('content')->end()
                    ->scalarNode('link')->end()
                    ->scalarNode('image_path')->end()
                ->end()
            ->end()
        ;

        return $translationsNodeDefinition;
    }
}
