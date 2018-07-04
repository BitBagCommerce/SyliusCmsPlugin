<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaTranslationInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MediaFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $mediaFactory;

    /** @var FactoryInterface */
    private $mediaTranslationFactory;

    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    /** @var ImageUploaderInterface */
    private $imageUploader;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var LocaleContextInterface */
    private $localeContext;

    public function __construct(
        FactoryInterface $mediaFactory,
        FactoryInterface $mediaTranslationFactory,
        MediaRepositoryInterface $mediaRepository,
        SectionRepositoryInterface $sectionRepository,
        ImageUploaderInterface $imageUploader,
        ProductRepositoryInterface $productRepository,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext
    ) {
        $this->mediaFactory = $mediaFactory;
        $this->mediaTranslationFactory = $mediaTranslationFactory;
        $this->mediaRepository = $mediaRepository;
        $this->sectionRepository = $sectionRepository;
        $this->imageUploader = $imageUploader;
        $this->productRepository = $productRepository;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $media = $this->mediaRepository->findOneBy(['code' => $code])
            ) {
                $this->mediaRepository->remove($media);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createMedia(md5(uniqid()), $fields);
                }
            } else {
                $this->createMedia($code, $fields);
            }
        }
    }

    private function createMedia(string $code, array $mediaData): void
    {
        /** @var MediaInterface $media */
        $media = $this->mediaFactory->createNew();
        $products = $mediaData['products'];

        if (null !== $products) {
            $this->resolveProducts($media, $products);
        }

        $this->resolveSections($media, $mediaData['sections']);

        $media->setType($mediaData['type']);
        $media->setCode($code);
        $media->setEnabled($mediaData['enabled']);
        $media->addChannel($this->channelContext->getChannel());

        foreach ($mediaData['translations'] as $localeCode => $translation) {
            /** @var MediaTranslationInterface $mediaTranslation */
            $mediaTranslation = $this->mediaTranslationFactory->createNew();

            $mediaTranslation->setLocale($localeCode);
            $mediaTranslation->setName($translation['name']);
            $mediaTranslation->setContent($translation['content']);
            $mediaTranslation->setLink($translation['link']);

            if (MediaInterface::IMAGE_MEDIA_TYPE === $type) {
                $image = new MediaImage();
                $path = $translation['image_path'];
                $uploadedImage = new UploadedFile($path, md5($path) . '.jpg');

                $image->setFile($uploadedImage);
                $mediaTranslation->setImage($image);

                $this->imageUploader->upload($image);
            }

            $media->addTranslation($mediaTranslation);
        }

        $this->mediaRepository->add($media);
    }

    private function resolveProducts(MediaInterface $media, int $limit): void
    {
        $products = $this->productRepository->findLatestByChannel(
            $this->channelContext->getChannel(),
            $this->localeContext->getLocaleCode(),
            $limit
        );

        foreach ($products as $product) {
            $media->addProduct($product);
        }
    }

    private function resolveSections(MediaInterface $media, array $sections): void
    {
        foreach ($sections as $sectionCode) {
            /** @var SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            $media->addSection($section);
        }
    }
}
