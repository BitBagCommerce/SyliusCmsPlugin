<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Entity\ContentConfiguration;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\Sylius\CmsPlugin\Behat\Helpers\ContentElementHelper;
use Tests\Sylius\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class BlockContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private RandomStringGeneratorInterface $randomStringGenerator,
        private FactoryInterface $blockFactory,
        private BlockRepositoryInterface $blockRepository,
    ) {
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
     * @Given there is a block with :code code
     */
    public function thereIsABlockWithCodeAndContent(string $code): void
    {
        $block = $this->createBlock($code);

        $this->saveBlock($block);
    }

    /**
     * @Given there is a block with :code code and :contentElement content element
     */
    public function thereIsABlockWithCodeAndContentElement(string $code, string $contentElement): void
    {
        $block = $this->createBlockWithContentElement($code, $contentElement);

        $this->saveBlock($block);
    }

    private function createBlock(
        ?string $code = null,
        ChannelInterface $channel = null,
    ): BlockInterface {
        /** @var BlockInterface $block */
        $block = $this->blockFactory->createNew();

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        $block->setCode($code);
        $block->addChannel($channel);

        return $block;
    }

    private function createBlockWithContentElement(string $code, string $contentElement): BlockInterface
    {
        $block = $this->createBlock($code);

        /** @var ContentConfigurationInterface $contentConfiguration */
        $contentConfiguration = new ContentConfiguration();
        $contentConfiguration->setType(mb_strtolower($contentElement));
        $contentConfiguration->setLocale('en_US');
        $contentConfiguration->setConfiguration(ContentElementHelper::getExampleConfigurationByContentElement($contentElement));
        $contentConfiguration->setBlock($block);

        $block->addContentElement($contentConfiguration);

        return $block;
    }

    private function saveBlock(BlockInterface $block): void
    {
        $this->blockRepository->add($block);
        $this->sharedStorage->set('block', $block);
    }
}
