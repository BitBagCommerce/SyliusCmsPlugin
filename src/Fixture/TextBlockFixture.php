<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Fixture;

use BitBag\CmsPlugin\Entity\Block;
use BitBag\CmsPlugin\Entity\BlockInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Wojciech Górski <wojciech.gorski@bitbag.pl>
 */
final class TextBlockFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $blockManager;

    /**
     * @param EntityManagerInterface $blockManager
     */
    public function __construct(EntityManagerInterface $blockManager)
    {
        $this->blockManager = $blockManager;
    }

    /**
     * @inheritDoc
     */
    public function load(array $options)
    {
        $block = new Block();

        $block->setCode($options['code']);
        $block->setType(BlockInterface::TEXT_BLOCK_TYPE);

        foreach ($options['translations'] as $translation) {
            $block->setCurrentLocale($translation['locale']);
            $block->setName($translation['name']);
            $block->setContent($translation['content']);
        }

        $this->blockManager->persist($block);

        $this->blockManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'bitbag_cms_block_text';
    }

    /**
     * @inheritDoc
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode)
    {
        $optionsNode
            ->children()
                ->scalarNode('code')->isRequired()->cannotBeEmpty()->end()
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