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

use BitBag\CmsPlugin\Entity\Block;
use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Wojciech Górski <wojciech.gorski@bitbag.pl>
 */
final class ImageBlockFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $blockManager;

    /**
     * @var ImageUploaderInterface
     */
    private $imageUploader;

    /**
     * @param EntityManagerInterface $blockManager
     * @param ImageUploaderInterface $imageUploader
     */
    public function __construct(EntityManagerInterface $blockManager, ImageUploaderInterface $imageUploader)
    {
        $this->blockManager = $blockManager;
        $this->imageUploader = $imageUploader;
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $options): void
    {
        $block = new Block();

        $block->setCode($options['code']);
        $block->setType(BlockInterface::IMAGE_BLOCK_TYPE);

        foreach ($options['translations'] as $translation) {
            $block->setCurrentLocale($translation['locale']);
            $block->setName($translation['name']);
            $block->setLink($translation['link']);

            $file = new File($translation['image']['filePath']);

            $image = new Image();
            $image->setFile($file);
            $image->setType($translation['image']['type']);

            $this->imageUploader->upload($image);

            $block->setImage($image);
        }

        $this->blockManager->persist($block);
        $this->blockManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'bitbag_cms_block_image';
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->scalarNode('code')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('translations')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('locale')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('link')->isRequired()->cannotBeEmpty()->end()
                            ->arrayNode('image')
                                ->children()
                                    ->scalarNode('type')->end()
                                    ->scalarNode('filePath')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}