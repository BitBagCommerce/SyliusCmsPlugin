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
use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webmozart\Assert\Assert;

final class PageFixtureFactory implements FixtureFactoryInterface
{
    public const CHANNEL_WITH_CODE_NOT_FOUND_MESSAGE = 'Channel with code "%s" not found';

    /** @var FactoryInterface */
    private $pageFactory;

    /** @var FactoryInterface */
    private $pageTranslationFactory;

    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ProductsAssignerInterface */
    private $productsAssigner;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    /** @var ChannelsAssignerInterface */
    private $channelAssigner;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    public function __construct(
        FactoryInterface $pageFactory,
        FactoryInterface $pageTranslationFactory,
        PageRepositoryInterface $pageRepository,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProductsAssignerInterface $productsAssigner,
        SectionsAssignerInterface $sectionsAssigner,
        ChannelsAssignerInterface $channelAssigner,
        ProductRepositoryInterface $productRepository,
        LocaleContextInterface $localeContext,
        ChannelRepositoryInterface $channelRepository,
    ) {
        $this->pageFactory = $pageFactory;
        $this->pageTranslationFactory = $pageTranslationFactory;
        $this->pageRepository = $pageRepository;
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->productsAssigner = $productsAssigner;
        $this->sectionsAssigner = $sectionsAssigner;
        $this->channelAssigner = $channelAssigner;
        $this->productRepository = $productRepository;
        $this->localeContext = $localeContext;
        $this->channelRepository = $channelRepository;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $page = $this->pageRepository->findOneBy(['code' => $code])
            ) {
                $this->pageRepository->remove($page);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createPage(md5(uniqid()), $fields, true);
                }
            } else {
                $this->createPage($code, $fields);
            }
        }
    }

    private function createPage(
        string $code,
        array $pageData,
        bool $generateSlug = false,
    ): void {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();
        $products = $pageData['products'];
        $channelsCodes = $pageData['channels'];
        if (null !== $products) {
            $this->resolveProductsForChannels($page, $products, $channelsCodes);
        }

        $this->sectionsAssigner->assign($page, $pageData['sections']);
        $this->productsAssigner->assign($page, $pageData['productCodes']);
        $this->channelAssigner->assign($page, $channelsCodes);

        $page->setCode($code);
        $page->setEnabled($pageData['enabled']);

        foreach ($pageData['translations'] as $localeCode => $translation) {
            /** @var PageTranslationInterface $pageTranslation */
            $pageTranslation = $this->pageTranslationFactory->createNew();
            $slug = true === $generateSlug ? md5(uniqid()) : $translation['slug'];

            $pageTranslation->setLocale($localeCode);
            $pageTranslation->setSlug($slug);
            $pageTranslation->setName($translation['name']);
            $pageTranslation->setNameWhenLinked($translation['name_when_linked']);
            $pageTranslation->setDescriptionWhenLinked($translation['description_when_linked']);
            $pageTranslation->setMetaKeywords($translation['meta_keywords']);
            $pageTranslation->setMetaDescription($translation['meta_description']);
            $pageTranslation->setContent($translation['content']);

            if ($translation['image_path']) {
                $image = new Media();
                $path = $translation['image_path'];
                $uploadedImage = new UploadedFile($path, md5($path) . '.jpg');

                $image->setFile($uploadedImage);
                $image->setCode(md5(uniqid()));
                $image->setType(MediaInterface::IMAGE_TYPE);
                $pageTranslation->setImage($image);

                $this->mediaProviderResolver->resolveProvider($image)->upload($image);
            }

            $page->addTranslation($pageTranslation);
        }

        $this->pageRepository->add($page);
    }

    private function resolveProductsForChannels(
        PageInterface $page,
        int $limit,
        array $channelCodes,
    ): void {
        foreach ($channelCodes as $channelCode) {
            /** @var ChannelInterface|null $channel */
            $channel = $this->channelRepository->findOneByCode($channelCode);
            Assert::notNull($channel, sprintf(self::CHANNEL_WITH_CODE_NOT_FOUND_MESSAGE, $channelCode));

            $this->resolveProductsForChannel($page, $limit, $channel);
        }
    }

    private function resolveProductsForChannel(
        PageInterface $page,
        int $limit,
        ChannelInterface $channel,
    ): void {
        $products = $this->productRepository->findLatestByChannel(
            $channel,
            $this->localeContext->getLocaleCode(),
            $limit,
        );

        foreach ($products as $product) {
            $page->addProduct($product);
        }
    }
}
