<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\Image;
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockContext implements Context
{
    const ALLOWED_TYPES = [
        BlockInterface::TEXT_BLOCK_TYPE,
        BlockInterface::IMAGE_BLOCK_TYPE,
    ];
    const IMAGE_MOCK = 'aston_martin_db_11.jpg';

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

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
     * @param BlockFactoryInterface $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     * @param ImageUploaderInterface $imageUploader
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        BlockFactoryInterface $blockFactory,
        BlockRepositoryInterface $blockRepository,
        ImageUploaderInterface $imageUploader
    )
    {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->sharedStorage = $sharedStorage;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @Given there are :number dynamic content blocks with :type type
     */
    public function thereAreDynamicContentBlocksWithType($number, $type)
    {
        $number = (int)$number;

        for ($i = 0; $i < $number; $i++) {

            if (BlockInterface::IMAGE_BLOCK_TYPE === $type) {
                $image = $this->uploadImage(self::IMAGE_MOCK);

                $this->createBlock($type, $image);

                continue;
            }

            $this->createBlock($type);
        }
    }

    /**
     * @Given there is a dynamic content block with :type type
     */
    public function thereIsADynamicContentBlockWithType($type)
    {
        if (BlockInterface::IMAGE_BLOCK_TYPE === $type) {
            $image = $this->uploadImage(self::IMAGE_MOCK);

            $this->createBlock($type, $image);

            return;
        }

        $this->createBlock($type);
    }

    /**
     * @Given there is a cms text block with :code code and :content content
     */
    public function thereIsATextCmsBlockWithCodeAndContent($code, $content)
    {
        $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE, null, $code, $content);
    }

    /**
     * @Given there is a cms block with :code code and :name image
     */
    public function thereIsCmsBlockWithCodeAndImage($code, $name)
    {
        $image = $this->uploadImage($name);

        $this->createBlock(BlockInterface::IMAGE_BLOCK_TYPE, $image, $code);
    }

    /**
     * @param $name
     *
     * @return ImageInterface
     */
    private function uploadImage($name)
    {
        $image = new Image();
        $uploadedImage = new UploadedFile(__DIR__ . '/../../Resources/images/' . $name, $name);
        $image->setFile($uploadedImage);

        $this->imageUploader->upload($image);

        return $image;
    }

    /**
     * @param string $type
     * @param ImageInterface|null $image
     * @param null|string $code
     * @param null|string $content
     */
    private function createBlock($type, ImageInterface $image = null, $code = null, $content = null)
    {
        Assert::oneOf($type, self::ALLOWED_TYPES);

        $code = null !== $code ? $code : time();
        $block = $this->blockFactory->createWithType($type);
        $block->setCode($code);

        if (null !== $image) {
            $this->setUpCurrentLocale($block);
            $block->setImage($image);
        }

        if (null !== $content) {
            $this->setUpCurrentLocale($block);
            $block->setContent($content);
        }

        $this->blockRepository->add($block);
        $this->sharedStorage->set('block', $block);
    }

    /**
     * @param BlockInterface $block
     */
    private function setUpCurrentLocale(BlockInterface $block)
    {
        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');
        $block->setCurrentLocale($channel->getLocales()->first()->getCode());
    }
}
