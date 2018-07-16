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

use BitBag\SyliusCmsPlugin\Assigner\ProductsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaTranslationInterface;
use BitBag\SyliusCmsPlugin\MediaProvider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\File;

final class MediaFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $mediaFactory;

    /** @var FactoryInterface */
    private $mediaTranslationFactory;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var ProductsAssignerInterface */
    private $productsAssigner;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    public function __construct(
        FactoryInterface $mediaFactory,
        FactoryInterface $mediaTranslationFactory,
        ChannelContextInterface $channelContext,
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaRepositoryInterface $mediaRepository,
        ProductsAssignerInterface $productsAssigner,
        SectionsAssignerInterface $sectionsAssigner
    ) {
        $this->mediaFactory = $mediaFactory;
        $this->mediaTranslationFactory = $mediaTranslationFactory;
        $this->channelContext = $channelContext;
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->mediaRepository = $mediaRepository;
        $this->productsAssigner = $productsAssigner;
        $this->sectionsAssigner = $sectionsAssigner;
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
        $media->addChannel($this->channelContext->getChannel());

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);

        foreach ($mediaData['translations'] as $localeCode => $translation) {
            /** @var MediaTranslationInterface $mediaTranslation */
            $mediaTranslation = $this->mediaTranslationFactory->createNew();

            $mediaTranslation->setLocale($localeCode);
            $mediaTranslation->setName($translation['name']);
            $mediaTranslation->setContent($translation['content']);
            $mediaTranslation->setAlt($translation['alt']);
            $media->addTranslation($mediaTranslation);
        }

        $this->sectionsAssigner->assign($media, $mediaData['sections']);
        $this->productsAssigner->assign($media, $mediaData['products']);

        $this->mediaRepository->add($media);
    }
}
