<?php

/**
 * This file was created by the developers from BitBag.
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

final class FrequentlyAskedQuestionFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var FixtureFactoryInterface
     */
    private $frequentlyAskedQuestionFixtureFactory;

    /**
     * @param FixtureFactoryInterface $frequentlyAskedQuestionFixtureFactory
     */
    public function __construct(FixtureFactoryInterface $frequentlyAskedQuestionFixtureFactory)
    {
        $this->frequentlyAskedQuestionFixtureFactory = $frequentlyAskedQuestionFixtureFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options): void
    {
        $this->frequentlyAskedQuestionFixtureFactory->load($options['custom']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'frequently_asked_question';
    }

    /**
     * {@inheritdoc}
     */
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
                            ->integerNode('position')->defaultNull()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
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
