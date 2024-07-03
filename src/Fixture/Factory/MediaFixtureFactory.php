<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\CollectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
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
