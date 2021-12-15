<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Webmozart\Assert\Assert;

final class MediaResourceResolver implements MediaResourceResolverInterface
{
    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        MediaRepositoryInterface $mediaRepository,
        LocaleContextInterface $localeContext,
        ChannelContextInterface $channelContext,
        LoggerInterface $logger
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->localeContext = $localeContext;
        $this->channelContext = $channelContext;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?MediaInterface
    {
        Assert::notNull($this->channelContext->getChannel()->getCode());
        $media = $this->mediaRepository->findOneEnabledByCode(
            $code,
            $this->localeContext->getLocaleCode(),
            $this->channelContext->getChannel()->getCode()
        );

        if (false === $media instanceof MediaInterface) {
            $this->logger->warning(sprintf(
                'Media with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $media;
    }
}
