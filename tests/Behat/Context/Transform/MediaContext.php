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
use Webmozart\Assert\Assert;

final class MediaContext implements Context
{
    /** @var MediaRepositoryInterface */
    private $mediaRepositoryInterface;

    /** @var string */
    private $locale;

    public function __construct(MediaRepositoryInterface $mediaRepositoryInterface, string $locale = 'en_US')
    {
        $this->mediaRepositoryInterface = $mediaRepositoryInterface;
        $this->locale = $locale;
    }

    /**
     * @Transform /^media(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" media(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :media
     */
    public function getMediaByCode(string $mediaCode): MediaInterface
    {
        $media = $this->mediaRepositoryInterface->findOneEnabledByCode($mediaCode, $this->locale);

        Assert::notNull(
            $media,
            sprintf('No media has been found with code "%s".', $mediaCode)
        );

        return $media;
    }
}
