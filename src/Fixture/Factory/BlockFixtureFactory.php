<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\BlockImage;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Factory\BlockFactoryInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    /**
     * @param BlockFactoryInterface $blockFactory
     * @param FactoryInterface $blockTranslationFactory
     * @param BlockRepositoryInterface $blockRepository
     * @param ImageUploaderInterface $imageUploader
     * @param ProductRepositoryInterface $productRepository
     * @param SectionRepositoryInterface $sectionRepository
     * @param ChannelContextInterface $channelContext
     * @param LocaleContextInterface $localeContext
     */
    public function __construct(
        BlockFactoryInterface $blockFactory,
        FactoryInterface $blockTranslationFactory,
        BlockRepositoryInterface $blockRepository,
        ImageUploaderInterface $imageUploader,
        ProductRepositoryInterface $productRepository,
        SectionRepositoryInterface $sectionRepository,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext
    )
    {
        $this->blockFactory = $blockFactory;
        $this->blockTranslationFactory = $blockTranslationFactory;
        $this->blockRepository = $blockRepository;
        $this->imageUploader = $imageUploader;
        $this->productRepository = $productRepository;
        $this->sectionRepository = $sectionRepository;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
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

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; $i++) {
                    $this->createBlock(md5(uniqid()), $fields);
                }
            } else {
                $this->createBlock($code, $fields);
            }
        }
    }

    private function createBlock(string $code, array $blockData): void
    {
        $type = $blockData['type'];
        $block = $this->blockFactory->createWithType($type);
        $products = $blockData['products'];

        if (null !== $products) {
            $this->resolveProducts($block, $products);
        }

        $this->resolveSections($block, $blockData['sections']);

        $block->setCode($code);
        $block->setEnabled($blockData['enabled']);

        foreach ($blockData['translations'] as $localeCode => $translation) {
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


    /**
     * @param BlockInterface $block
     * @param int $limit
     */
    private function resolveProducts(BlockInterface $block, int $limit): void
    {
        $products = $this->productRepository->findLatestByChannel(
            $this->channelContext->getChannel(),
            $this->localeContext->getLocaleCode(),
            $limit
        );

        foreach ($products as $product) {
            $block->addProduct($product);
        }
    }

    /**
     * @param BlockInterface $block
     * @param array $sections
     */
    private function resolveSections(BlockInterface $block, array $sections): void
    {
        foreach ($sections as $sectionCode) {
            /** @var SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            $block->addSection($section);
        }
    }
}
