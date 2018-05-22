<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class PageFixture extends AbstractFixture implements FixtureInterface
{
    /** @var FixtureFactoryInterface */
    private $pageFixtureFactory;

    public function __construct(FixtureFactoryInterface $pageFixtureFactory)
    {
        $this->pageFixtureFactory = $pageFixtureFactory;
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
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->integerNode('number')->defaultNull()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->integerNode('products')->defaultNull()->end()
                            ->arrayNode('sections')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('slug')->defaultNull()->end()
                                        ->scalarNode('name')->defaultNull()->end()
                                        ->scalarNode('meta_keywords')->defaultNull()->end()
                                        ->scalarNode('meta_description')->defaultNull()->end()
                                        ->scalarNode('content')->defaultNull()->end()
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
