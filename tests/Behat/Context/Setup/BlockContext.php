<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\BlockImage;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Factory\BlockFactoryInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

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
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->imageUploader = $imageUploader;
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
     * @param string|null $code
     * @param string|null $content
     * @param string|null $image
     * @param ChannelInterface $channel
     *
     * @return BlockInterface
     */
    private function createBlock(
        string $type,
        ?string $code = null,
        ?string $content = null,
        string $image = null,
        ChannelInterface $channel = null
    ): BlockInterface {
        $block = $this->blockFactory->createWithType($type);

        $block->setCurrentLocale('en_US');

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

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
        $block->addChannel($channel);

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
