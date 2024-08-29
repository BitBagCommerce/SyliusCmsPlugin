<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Fixture\Factory;

use Sylius\CmsPlugin\Assigner\ChannelsAssignerInterface;
use Sylius\CmsPlugin\Assigner\CollectionsAssignerInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Entity\MediaTranslationInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MediaFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $mediaFactory,
        private FactoryInterface $mediaTranslationFactory,
        private MediaProviderResolverInterface $mediaProviderResolver,
        private MediaRepositoryInterface $mediaRepository,
        private CollectionsAssignerInterface $collectionsAssigner,
        private ChannelsAssignerInterface $channelAssigner,
    ) {
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            /** @var ?MediaInterface $media */
            $media = $this->mediaRepository->findOneBy(['code' => $code]);
            if (
                true === $fields['remove_existing'] &&
                null !== $media
            ) {
                $this->mediaRepository->remove($media);
            }

            $this->createMedia($code, $fields);
        }
    }

    private function createMedia(string $code, array $mediaData): void
    {
        /** @var MediaInterface $media */
        $media = $this->mediaFactory->createNew();
        $media->setType($mediaData['type']);
        $media->setCode($code);
        $media->setName($mediaData['name']);
        $media->setEnabled($mediaData['enabled']);
        $media->setFile(new UploadedFile($mediaData['path'], $mediaData['original_name']));

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);

        foreach ($mediaData['translations'] as $localeCode => $translation) {
            /** @var MediaTranslationInterface $mediaTranslation */
            $mediaTranslation = $this->mediaTranslationFactory->createNew();

            $mediaTranslation->setLocale($localeCode);
            $mediaTranslation->setContent($translation['content']);
            $mediaTranslation->setAlt($translation['alt']);
            $mediaTranslation->setLink($translation['link']);
            $media->addTranslation($mediaTranslation);
        }

        $this->collectionsAssigner->assign($media, $mediaData['collections']);
        $this->channelAssigner->assign($media, $mediaData['channels']);

        $this->mediaRepository->add($media);
    }
}
