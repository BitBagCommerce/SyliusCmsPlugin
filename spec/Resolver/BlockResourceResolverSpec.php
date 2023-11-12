<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolver;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;

final class BlockResourceResolverSpec extends ObjectBehavior
{
    public function let(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger,
        ChannelContextInterface $channelContext
    ) {
        $this->beConstructedWith($blockRepository, $logger, $channelContext);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BlockResourceResolver::class);
    }

    public function it_implements_block_resource_resolver_interface(): void
    {
        $this->shouldHaveType(BlockResourceResolverInterface::class);
    }

    public function it_logs_warning_if_block_was_not_found(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel
    ) {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $blockRepository->findEnabledByCode('homepage_banner', 'WEB')->willReturn(null);

        $logger
            ->warning(sprintf(
                'Block with "%s" code was not found in the database.',
                'homepage_banner'
            ))
            ->shouldBeCalled()
        ;

        $this->findOrLog('homepage_banner');
    }

    public function it_returns_block_if_found_in_database(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel
    ) {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $blockRepository->findEnabledByCode('homepage_banner', 'WEB')->willReturn($block);

        $this->findOrLog('homepage_banner')->shouldReturn($block);
    }
}
