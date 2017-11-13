<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Fixture\Factory;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\BlockTranslationInterface;
use BitBag\CmsPlugin\Entity\BlockImage;
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockFixtureFactory implements FixtureFactoryInterface
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
    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $block = $this->blockRepository->findOneBy(['code' => $code])
            ) {
                $this->blockRepository->remove($block);
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
                $blockTranslation->setLink($translation['link']);

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
}
