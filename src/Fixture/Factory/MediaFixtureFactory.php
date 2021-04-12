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

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\ProductsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\File;

final class MediaFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $mediaFactory;

    /** @var FactoryInterface */
    private $mediaTranslationFactory;

    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var ProductsAssignerInterface */
    private $productsAssigner;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    /** @var ChannelsAssignerInterface */
    private $channelAssigner;

    public function __construct(
        FactoryInterface $mediaFactory,
        FactoryInterface $mediaTranslationFactory,
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaRepositoryInterface $mediaRepository,
        ProductsAssignerInterface $productsAssigner,
        SectionsAssignerInterface $sectionsAssigner,
        ChannelsAssignerInterface $channelAssigner
    ) {
        $this->mediaFactory = $mediaFactory;
        $this->mediaTranslationFactory = $mediaTranslationFactory;
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->mediaRepository = $mediaRepository;
        $this->productsAssigner = $productsAssigner;
        $this->sectionsAssigner = $sectionsAssigner;
        $this->channelAssigner = $channelAssigner;
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
        $media->setType($mediaData['type']);
        $media->setCode($code);
        $media->setEnabled($mediaData['enabled']);
        $media->setFile(new File($mediaData['path']));

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);

        foreach ($mediaData['translations'] as $localeCode => $translation) {
            /** @var MediaTranslationInterface $mediaTranslation */
            $mediaTranslation = $this->mediaTranslationFactory->createNew();

            $mediaTranslation->setLocale($localeCode);
            $mediaTranslation->setName($translation['name']);
            $mediaTranslation->setContent($translation['content']);
            $mediaTranslation->setAlt($translation['alt']);
            $mediaTranslation->setLink($translation['link']);
            $media->addTranslation($mediaTranslation);
        }

        $this->sectionsAssigner->assign($media, $mediaData['sections']);
        $this->productsAssigner->assign($media, $mediaData['productCodes']);
        $this->channelAssigner->assign($media, $mediaData['channels']);

        $this->mediaRepository->add($media);
    }
}
