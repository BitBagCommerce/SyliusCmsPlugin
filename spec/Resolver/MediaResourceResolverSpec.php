<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Resolver\MediaResourceResolver;
use Sylius\CmsPlugin\Resolver\MediaResourceResolverInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;

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
