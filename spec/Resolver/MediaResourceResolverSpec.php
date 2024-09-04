<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaResourceResolver;
use BitBag\SyliusCmsPlugin\Resolver\MediaResourceResolverInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class MediaResourceResolverSpec extends ObjectBehavior
{
    public function let(
        MediaRepositoryInterface $mediaRepository,
        ChannelContextInterface $channelContext,
        LoggerInterface $logger,
    ) {
        $this->beConstructedWith($mediaRepository, $channelContext, $logger);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MediaResourceResolver::class);
    }

    public function it_implements_media_resource_resolver_interface(): void
    {
        $this->shouldHaveType(MediaResourceResolverInterface::class);
    }

    public function it_returns_media_when_found(
        MediaRepositoryInterface $mediaRepository,
        ChannelContextInterface $channelContext,
        MediaInterface $media,
        ChannelInterface $channel,
    ) {
        $code = 'media_code';
        $channelCode = 'ecommerce';

        $channelContext->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn($channelCode);

        $mediaRepository->findOneEnabledByCode($code, $channelCode)->willReturn($media);

        $this->findOrLog($code)->shouldReturn($media);
    }

    public function it_logs_warning_and_returns_null_when_media_not_found(
        MediaRepositoryInterface $mediaRepository,
        ChannelContextInterface $channelContext,
        LoggerInterface $logger,
        ChannelInterface $channel,
    ) {
        $code = 'non_existing_code';
        $channelCode = 'ecommerce';

        $channelContext->getChannel()->willReturn($channel);
        $channel->getCode()->willReturn($channelCode);

        $mediaRepository->findOneEnabledByCode($code, $channelCode)->willReturn(null);

        $logger->warning(sprintf('Media with "%s" code was not found in the database.', $code))->shouldBeCalled();

        $this->findOrLog($code)->shouldReturn(null);
    }
}
