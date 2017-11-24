<?php

/**
 * This file has been created by the developers from BitBag.
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

final class SectionFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var FixtureFactoryInterface
     */
    private $sectionFixtureFactory;

    /**
     * @param FixtureFactoryInterface $sectionFixtureFactory
     */
    public function __construct(FixtureFactoryInterface $sectionFixtureFactory)
    {
        $this->sectionFixtureFactory = $sectionFixtureFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $options): void
    {
        $this->sectionFixtureFactory->load($options['custom']);
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'section';
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->defaultNull()->end()
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
