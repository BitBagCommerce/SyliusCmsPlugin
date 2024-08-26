<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Assigner;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\ChannelsAssigner;
use Sylius\CmsPlugin\Assigner\ChannelsAssignerInterface;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

final class ChannelsAssignerSpec extends ObjectBehavior
{
    public function let(ChannelRepositoryInterface $channelRepository): void
    {
        $this->beConstructedWith($channelRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ChannelsAssigner::class);
    }

    public function it_implements_channels_assigner_interface(): void
    {
        $this->shouldHaveType(ChannelsAssignerInterface::class);
    }

    public function it_assigns_channels(
        ChannelRepositoryInterface $channelRepository,
        ChannelInterface $webChannel,
        ChannelInterface $posChannel,
        ChannelsAwareInterface $channelsAware,
    ): void {
        $channelRepository->findOneBy(['code' => 'web'])->willReturn($webChannel);
        $channelRepository->findOneBy(['code' => 'pos'])->willReturn($posChannel);

        $channelsAware->addChannel($webChannel)->shouldBeCalled();
        $channelsAware->addChannel($posChannel)->shouldBeCalled();

        $this->assign($channelsAware, ['web', 'pos']);
    }
}
