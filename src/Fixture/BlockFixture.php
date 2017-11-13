<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Fixture;

use BitBag\CmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var FixtureFactoryInterface
     */
    private $blockFixtureFactory;

    /**
     * @param FixtureFactoryInterface $blockFixtureFactory
     */
    public function __construct(FixtureFactoryInterface $blockFixtureFactory)
    {
        $this->blockFixtureFactory = $blockFixtureFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options): void
    {
        $this->blockFixtureFactory->load($options['custom']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'block';
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
                            ->booleanNode('last_four_products')->defaultFalse()->end()
                            ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->defaultNull()->end()
                                        ->scalarNode('content')->defaultNull()->end()
                                        ->scalarNode('link')->defaultNull()->end()
                                        ->scalarNode('image_path')->defaultNull()->end()
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
