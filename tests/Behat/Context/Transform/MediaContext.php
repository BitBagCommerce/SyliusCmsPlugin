<?php

/*
 *  This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 *  You can find more information about us on https://bitbag.shop and write us
 *  an email on mikolaj.krol@bitbag.pl.
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
    /** @var MediaRepositoryInterface */
    private $mediaRepositoryInterface;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(
        MediaRepositoryInterface $mediaRepositoryInterface,
        SharedStorageInterface $sharedStorage
    ) {
        $this->mediaRepositoryInterface = $mediaRepositoryInterface;
        $this->sharedStorage = $sharedStorage;
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
            $this->sharedStorage->get('channel')->getCode()
        );

        Assert::notNull(
            $media,
            sprintf('No media has been found with code "%s".', $mediaCode)
        );

        return $media;
    }
}
