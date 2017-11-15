<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\BlockImage;
use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockContext implements Context
{
    const IMAGE_MOCK = 'aston_martin_db_11.jpg';

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RandomStringGeneratorInterface
     */
    private $randomStringGenerator;

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
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param BlockFactoryInterface $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     * @param ImageUploaderInterface $imageUploader
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        BlockFactoryInterface $blockFactory,
        BlockRepositoryInterface $blockRepository,
        ImageUploaderInterface $imageUploader
    )
    {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->sharedStorage = $sharedStorage;
        $this->imageUploader = $imageUploader;
        $this->randomStringGenerator = $randomStringGenerator;
    }

    /**
     * @Given there is a block in the store
     */
    public function thereIsABlockInTheStore(): void
    {
        $block = $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE);

        $this->saveBlock($block);
    }

    /**
     * @Given there is a dynamic content block with :type type
     */
    public function thereIsADynamicContentBlockWithType(string $type): void
    {
        $block = $this->createBlock($type);

        $this->saveBlock($block);
    }

    /**
     * @Given there is an existing block with :code code
     */
    public function thereIsABlockWithCode(string $code): void
    {
        $block = $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE, $code);

        $this->saveBlock($block);
    }

    /**
     * @Given there is a text block with :code code and :content content
     */
    public function thereIsATextBlockWithCodeAndContent(string $code, string $content): void
    {
        $block = $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE, $code, $content);

        $this->saveBlock($block);
    }

    /**
     * @Given there is a html block with :code code and :content content
     */
    public function thereIsAHtmlBlockWithCodeAndContent(string $code, string $content): void
    {
        $block = $this->createBlock(BlockInterface::HTML_BLOCK_TYPE, $code, $content);

        $this->saveBlock($block);
    }

    /**
     * @Given there is an existing block with :code code and :image image
     */
    public function thereIsAnExistingBlockWithCodeAndImage(string $code, string $image): void
    {
        $block = $this->createBlock(BlockInterface::IMAGE_BLOCK_TYPE, $code, null, $image);

        $this->saveBlock($block);
    }

    /**
     * @param string $type
     * @param null|string $code
     * @param null|string $content
     * @param string|null $image
     *
     * @return BlockInterface
     */
    private function createBlock(
        string $type,
        ?string $code = null,
        ?string $content = null,
        string $image = null
    ): BlockInterface
    {
        $block = $this->blockFactory->createWithType($type);

        $block->setCurrentLocale('en_US');

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE === $type && null !== $image) {
            $image = $this->uploadImage($image);

            $block->setImage($image);
        }

        if (true === in_array($type, [BlockInterface::HTML_BLOCK_TYPE, BlockInterface::TEXT_BLOCK_TYPE])) {
            if (null === $content) {
                $content = $this->randomStringGenerator->generate();
            }

            $block->setContent($content);
        }

        $block->setCode($code);

        return $block;
    }

    /**
     * @param string $name
     *
     * @return ImageInterface
     */
    private function uploadImage(string $name): ImageInterface
    {
        $image = new BlockImage();
        $uploadedImage = new UploadedFile(__DIR__ . '/../../Resources/images/' . $name, $name);

        $image->setFile($uploadedImage);

        $this->imageUploader->upload($image);

        return $image;
    }

    /**
     * @param BlockInterface $block
     */
    private function saveBlock(BlockInterface $block): void
    {
        $this->blockRepository->add($block);
        $this->sharedStorage->set('block', $block);
    }
}
