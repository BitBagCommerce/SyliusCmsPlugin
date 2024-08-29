<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Webmozart\Assert\Assert;

final class MediaContext implements Context
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepositoryInterface,
        private SharedStorageInterface $sharedStorage,
    ) {
    }

    /**
     * @Transform /^media(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" media(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :media
     */
    public function getMediaByCode(string $mediaCode): MediaInterface
    {
        $media = $this->mediaRepositoryInterface->findOneEnabledByCode(
            $mediaCode,
            $this->sharedStorage->get('locale')->getCode(),
            $this->sharedStorage->get('channel')->getCode(),
        );

        Assert::notNull(
            $media,
            sprintf('No media has been found with code "%s".', $mediaCode),
        );

        return $media;
    }
}
