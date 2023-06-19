<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\ProductsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\TaxonsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class BlockFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $blockFactory;

    /** @var FactoryInterface */
    private $blockTranslationFactory;

    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ProductsAssignerInterface */
    private $productsAssigner;

    /** @var TaxonsAssignerInterface */
    private $taxonsAssigner;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    /** @var ChannelsAssignerInterface */
    private $channelAssigner;

    public function __construct(
        FactoryInterface $blockFactory,
        FactoryInterface $blockTranslationFactory,
        BlockRepositoryInterface $blockRepository,
        ProductRepositoryInterface $productRepository,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext,
        ProductsAssignerInterface $productsAssigner,
        TaxonsAssignerInterface $taxonsAssigner,
        SectionsAssignerInterface $sectionsAssigner,
        ChannelsAssignerInterface $channelAssigner,
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockTranslationFactory = $blockTranslationFactory;
        $this->blockRepository = $blockRepository;
        $this->productRepository = $productRepository;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
        $this->productsAssigner = $productsAssigner;
        $this->taxonsAssigner = $taxonsAssigner;
        $this->sectionsAssigner = $sectionsAssigner;
        $this->channelAssigner = $channelAssigner;
    }

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
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createBlock(md5(uniqid()), $fields);
                }
            } else {
                $this->createBlock($code, $fields);
            }
        }
    }

    private function createBlock(string $code, array $blockData): void
    {
        /** @var BlockInterface $block */
        $block = $this->blockFactory->createNew();

        $products = $blockData['products'];
        if (null !== $products) {
            $this->resolveProducts($block, $products);
        }

        $this->sectionsAssigner->assign($block, $blockData['sections']);
        $this->productsAssigner->assign($block, $blockData['productCodes']);
        $this->taxonsAssigner->assign($block, $blockData['taxons']);
        $this->channelAssigner->assign($block, $blockData['channels']);

        $block->setCode($code);
        $block->setEnabled($blockData['enabled']);

        foreach ($blockData['translations'] as $localeCode => $translation) {
            /** @var BlockTranslationInterface $blockTranslation */
            $blockTranslation = $this->blockTranslationFactory->createNew();

            $blockTranslation->setLocale($localeCode);
            $blockTranslation->setName($translation['name']);
            $blockTranslation->setContent($translation['content']);
            $blockTranslation->setLink($translation['link']);
            $block->addTranslation($blockTranslation);
        }

        $this->blockRepository->add($block);
    }

    private function resolveProducts(BlockInterface $block, int $limit): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();
        $products = $this->productRepository->findLatestByChannel(
            $channel,
            $this->localeContext->getLocaleCode(),
            $limit,
        );
        foreach ($products as $product) {
            $block->addProduct($product);
        }
    }
}
