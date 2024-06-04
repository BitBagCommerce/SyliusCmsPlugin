<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
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
