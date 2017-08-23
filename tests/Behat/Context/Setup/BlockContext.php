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
use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockContext implements Context
{
    /**
     * @var BlockFactoryInterface
     */
    private $blockFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @param BlockFactoryInterface $blockFactory
     * @param EntityManagerInterface $entityManager
     * @param SharedStorageInterface $sharedStorage
     */
    public function __construct(
        BlockFactoryInterface $blockFactory,
        EntityManagerInterface $entityManager,
        SharedStorageInterface $sharedStorage
    )
    {
        $this->blockFactory = $blockFactory;
        $this->entityManager = $entityManager;
        $this->sharedStorage = $sharedStorage;
    }

    const ALLOWED_TYPES = [
        BlockInterface::TEXT_BLOCK_TYPE,
        BlockInterface::IMAGE_BLOCK_TYPE,
    ];

    /**
     * @Given there are :number dynamic content blocks with :type type
     */
    public function thereAreDynamicContentBlocksWithType($number, $type)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->createBlock($type);
        }
    }

    /**
     * @Given there is a dynamic content block with :type type
     */
    public function thereIsADynamicContentBlockWithType($type)
    {
        $this->createBlock($type);
    }

    /**
     * @Given there is a cms text block with :code code and :content content
     */
    public function thereIsATextCmsBlockWithCodeAndContent($code, $content)
    {
        $this->createBlock(BlockInterface::TEXT_BLOCK_TYPE, $code, $content);
    }

    /**
     * @param string $type
     * @param null|string $code
     * @param null|string $content
     */
    private function createBlock($type, $code = null, $content = null)
    {
        Assert::oneOf($type, self::ALLOWED_TYPES);

        $code = null === $code ? time() : $code;
        $block = $this->blockFactory->createWithType($type);
        $block->setCode($code);

        if (null !== $content) {
            Assert::string($content);

            $block->setContent($content);
        }

        $this->entityManager->persist($block);
        $this->entityManager->flush();
        $this->sharedStorage->set('block', $block);
    }
}
