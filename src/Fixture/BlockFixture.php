<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Fixture;

use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var BlockFactoryInterface
     */
    private $blockFactory;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @param BlockFactoryInterface $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        BlockFactoryInterface $blockFactory,
        BlockRepositoryInterface $blockRepository
    )
    {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $options): void
    {
        $block = $this->blockFactory->createWithType($options['type']);

        $block->setCode($options['code']);

        foreach ($options['translations'] as $translation) {
            $block->setCurrentLocale($translation['locale']);
            $block->setName($translation['name']);
            $block->setContent($translation['content']);
        }

        $this->blockRepository->add($block);
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'bitbag_cms_block';
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->scalarNode('code')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                    ->arrayNode('translations')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('locale')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('content')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                ->end()
            ->end()
        ;
    }
}