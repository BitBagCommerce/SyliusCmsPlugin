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

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\Image;
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var ImageUploaderInterface
     */
    private $imageUploader;

    /**
     * @param BlockFactoryInterface $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     * @param ImageUploaderInterface $imageUploader
     */
    public function __construct(
        BlockFactoryInterface $blockFactory,
        BlockRepositoryInterface $blockRepository,
        ImageUploaderInterface $imageUploader
    )
    {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->imageUploader = $imageUploader;
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $options): void
    {
        $type = $options['type'];
        $block = $this->blockFactory->createWithType($type);

        $block->setCode($options['code']);

        foreach ($options['translations'] as $localeCode => $translation) {
            $block->setCurrentLocale($localeCode);
            $block->setName($translation['name']);
            $block->setContent($translation['content']);

            if (BlockInterface::IMAGE_BLOCK_TYPE === $type) {
                $image = new Image();
                $path = $translation['image_path'];
                $uploadedImage = new UploadedFile($path, md5($path) . '.jpg');

                $image->setFile($uploadedImage);
                $block->setImage($image);

                $this->imageUploader->upload($image);
            }
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
                                ->scalarNode('name')->defaultValue(null)->end()
                                ->scalarNode('content')->defaultValue(null)->end()
                                ->scalarNode('link')->defaultValue(null)->end()
                                ->scalarNode('image_path')->defaultValue(null)->end()
                            ->end()
                        ->end()
                ->end()
            ->end()
        ;
    }
}