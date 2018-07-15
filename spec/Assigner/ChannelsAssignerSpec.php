<?php

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

final class ChannelsAssignerSpec extends ObjectBehavior
{
    function let(ChannelRepositoryInterface $channelRepository): void
    {
        $this->beConstructedWith($channelRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChannelsAssigner::class);
    }

    function it_implements_channels_assigner_interface(): void
    {
        $this->shouldHaveType(ChannelsAssignerInterface::class);
    }

    function it_assigns_channels(
        ChannelRepositoryInterface $channelRepository,
        ChannelInterface $webChannel,
        ChannelInterface $posChannel,
        ChannelsAwareInterface $channelsAware
    ): void
    {
        $channelRepository->findOneBy(['code' => 'web'])->willReturn($webChannel);
        $channelRepository->findOneBy(['code' => 'pos'])->willReturn($posChannel);

        $channelsAware->addChannel($webChannel)->shouldBeCalled();
        $channelsAware->addChannel($posChannel)->shouldBeCalled();

        $this->assign($channelsAware, ['web', 'pos']);
    }
}
