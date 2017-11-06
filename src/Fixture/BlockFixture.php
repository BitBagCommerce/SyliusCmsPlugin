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
use BitBag\CmsPlugin\Entity\BlockTranslationInterface;
use BitBag\CmsPlugin\Entity\BlockImage;
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
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
     * @var FactoryInterface
     */
    private $blockTranslationFactory;

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
     * @param FactoryInterface $blockTranslationFactory
     * @param BlockRepositoryInterface $blockRepository
     * @param ImageUploaderInterface $imageUploader
     */
    public function __construct(
        BlockFactoryInterface $blockFactory,
        FactoryInterface $blockTranslationFactory,
        BlockRepositoryInterface $blockRepository,
        ImageUploaderInterface $imageUploader
    )
    {
        $this->blockFactory = $blockFactory;
        $this->blockTranslationFactory = $blockTranslationFactory;
        $this->blockRepository = $blockRepository;
        $this->imageUploader = $imageUploader;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options): void
    {
        foreach ($options['blocks'] as $code => $fields) {

            if (null !== $this->blockRepository->findOneBy(['code' => $code])) {
                continue;
            }

            $type = $fields['type'];
            $block = $this->blockFactory->createWithType($type);

            $block->setCode($code);
            $block->setEnabled($fields['enabled']);

            foreach ($fields['translations'] as $localeCode => $translation) {
                /** @var BlockTranslationInterface $blockTranslation */
                $blockTranslation = $this->blockTranslationFactory->createNew();

                $blockTranslation->setLocale($localeCode);
                $blockTranslation->setName($translation['name']);
                $blockTranslation->setContent($translation['content']);

                if (BlockInterface::IMAGE_BLOCK_TYPE === $type) {
                    $image = new BlockImage();
                    $path = $translation['image_path'];
                    $uploadedImage = new UploadedFile($path, md5($path) . '.jpg');

                    $image->setFile($uploadedImage);
                    $blockTranslation->setImage($image);

                    $this->imageUploader->upload($image);
                }

                $block->addTranslation($blockTranslation);
            }

            $this->blockRepository->add($block);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'bitbag_cms_block';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('blocks')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('enabled')->defaultTrue()->end()
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
