<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class BlockContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var RandomStringGeneratorInterface */
    private $randomStringGenerator;

    /** @var FactoryInterface */
    private $blockFactory;

    /** @var BlockRepositoryInterface */
    private $blockRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $blockFactory,
        BlockRepositoryInterface $blockRepository,
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @Given there is a dynamic content block
     * @Given there is a block in the store
     */
    public function thereIsADynamicContentBlock(): void
    {
        $block = $this->createBlock();

        $this->saveBlock($block);
    }

    /**
     * @Given there is an existing block with :code code
     */
    public function thereIsABlockWithCode(string $code): void
    {
        $block = $this->createBlock($code);

        $this->saveBlock($block);
    }

    /**
     * @Given there is a block with :code code and :content content
     */
    public function thereIsABlockWithCodeAndContent(string $code, string $content): void
    {
        $block = $this->createBlock($code, $content);

        $this->saveBlock($block);
    }

    private function createBlock(
        ?string $code = null,
        ?string $content = null,
        ChannelInterface $channel = null,
    ): BlockInterface {
        /** @var BlockInterface $block */
        $block = $this->blockFactory->createNew();

        $block->setCurrentLocale('en_US');

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $content) {
            $content = $this->randomStringGenerator->generate();
        }

        $block->setCode($code);
        $block->setContent($content);
        $block->addChannel($channel);

        return $block;
    }

    private function saveBlock(BlockInterface $block): void
    {
        $this->blockRepository->add($block);
        $this->sharedStorage->set('block', $block);
    }
}
