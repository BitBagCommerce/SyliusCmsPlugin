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

final class FrequentlyAskedQuestionFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $frequentlyAskedQuestionFixtureFactory;

    public function __construct(FixtureFactoryInterface $frequentlyAskedQuestionFixtureFactory)
    {
        $this->frequentlyAskedQuestionFixtureFactory = $frequentlyAskedQuestionFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->frequentlyAskedQuestionFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'frequently_asked_question';
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
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->integerNode('position')->defaultNull()->end()
                            ->arrayNode('channels')->scalarPrototype()->end()->end()
                            ->arrayNode('translations')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('question')->defaultNull()->end()
                                        ->scalarNode('answer')->defaultNull()->end()
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
