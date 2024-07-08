<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class MediaContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private RandomStringGeneratorInterface $randomStringGenerator,
        private FactoryInterface $mediaFactory,
        private MediaRepositoryInterface $mediaRepository,
        private MediaProviderResolverInterface $mediaProviderResolver,
    ) {
    }

    /**
     * @Given there is an existing media with :code code
     */
    public function thereIsAnExistingMediaWithCode(string $code): void
    {
        $media = $this->createMedia($code);

        $this->uploadFile($media, 'aston_martin_db_11.jpg');

        $this->saveMedia($media);
    }

    /**
     * @Given there is an existing media with :code code and name :name
     */
    public function thereIsAnExistingMediaWithCodeAndName(string $code, string $name): void
    {
        $media = $this->createMedia($code, $name);

        $this->uploadFile($media, 'aston_martin_db_11.jpg');

        $this->saveMedia($media);
    }

    /**
     * @Given there is an existing :type media with :code code
     */
    public function thereIsAnExistingTypeMediaWithCode(string $type, string $code): void
    {
        $media = $this->createMedia($code, null, null, $type);

        $this->uploadFile($media, 'aston_martin_db_11.jpg');

        $this->saveMedia($media);
    }

    private function createMedia(
        ?string $code = null,
        ?string $name = null,
        ?string $content = null,
        ?string $fileType = null,
        ChannelInterface $channel = null,
    ): MediaInterface {
        /** @var MediaInterface $media */
        $media = $this->mediaFactory->createNew();

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $name) {
            $name = $this->randomStringGenerator->generate();
        }

        if (null === $content) {
            $content = $this->randomStringGenerator->generate();
        }

        if (null === $fileType) {
            $fileType = MediaInterface::FILE_TYPE;
        }

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

        $media->setCode($code);
        $media->setCurrentLocale('en_US');
        $media->setName($name);
        $media->setContent($content);
        $media->setType($fileType);
        $media->addChannel($channel);

        return $media;
    }

    private function uploadFile(MediaInterface $media, string $name): MediaInterface
    {
        $uploadedFile = new UploadedFile(__DIR__ . '/../../Resources/images/' . $name, $name);

        $media->setFile($uploadedFile);

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);

        return $media;
    }

    private function saveMedia(MediaInterface $media): void
    {
        $this->mediaRepository->add($media);
        $this->sharedStorage->set('media', $media);
    }
}
