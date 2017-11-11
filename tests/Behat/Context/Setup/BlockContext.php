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
use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\BlockImage;
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockContext implements Context
{
    const IMAGE_MOCK = 'aston_martin_db_11.jpg';
    const ALLOWED_TYPES = [
        BlockInterface::TEXT_BLOCK_TYPE,
        BlockInterface::HTML_BLOCK_TYPE,
        BlockInterface::IMAGE_BLOCK_TYPE,
    ];

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
     * @Given there are :number dynamic content blocks with :type type
     */
    public function thereAreDynamicContentBlocksWithType(int $number, string $type): void
    {
        for ($i = 0; $i < $number; $i++) {

            if (BlockInterface::IMAGE_BLOCK_TYPE === $type) {
                $image = $this->uploadImage(self::IMAGE_MOCK);

                $this->createBlock($type, $image, uniqid('', true));

                continue;
            }

            $this->createBlock($type, null, uniqid('', true));
        }
    }

    /**
     * @Given there is a dynamic content block with :type type
     */
    public function thereIsADynamicContentBlockWithType(string $type): void
    {
        if (BlockInterface::IMAGE_BLOCK_TYPE === $type) {
            $image = $this->uploadImage(self::IMAGE_MOCK);

            $this->createBlock($type, $image);

            return;
        }

        $this->createBlock($type);
    }

    /**
     * @Given there is a cms block with :code code
     */
    public function thereIsATextCmsBlockWithCode(string $code): void
    {
        $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE, null, $code);
    }

    /**
     * @Given there is a cms text block with :code code and :content content
     */
    public function thereIsATextCmsBlockWithCodeAndContent(string $code, string $content): void
    {
        $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE, null, $code, $content);
    }

    /**
     * @Given there is a cms html block with :code code and :content content
     */
    public function thereIsAHtmlCmsBlockWithCodeAndContent($code, $content): void
    {
        $this->createBlock(BlockInterface::HTML_BLOCK_TYPE, null, $code, $content);
    }

    /**
     * @Given there is a cms block with :code code and :name image
     */
    public function thereIsCmsBlockWithCodeAndImage(string $code, string $name): void
    {
        $image = $this->uploadImage($name);

        $this->createBlock(BlockInterface::IMAGE_BLOCK_TYPE, $image, $code);
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
     * @param string $type
     * @param null|ImageInterface $image
     * @param null|string $code
     * @param null|string $content
     */
    private function createBlock(
        string $type,
        ImageInterface $image = null,
        string $code = null,
        string $content = null
    ): void
    {
        Assert::oneOf($type, self::ALLOWED_TYPES);

        $code = null !== $code ? $code : $this->randomStringGenerator->generate();
        $block = $this->blockFactory->createWithType($type);

        $block->setCode($code);
        $this->setUpCurrentLocale($block);

        if (null !== $image) {
            $block->setImage($image);
        }

        if (null !== $content) {
            $block->setContent($content);
        } else {
            $block->setContent($this->randomStringGenerator->generate());
        }

        $this->blockRepository->add($block);
        $this->sharedStorage->set('block', $block);
    }

    /**
     * @param BlockInterface $block
     */
    private function setUpCurrentLocale(BlockInterface $block): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');

        $block->setCurrentLocale($channel->getLocales()->first()->getCode());
    }
}
