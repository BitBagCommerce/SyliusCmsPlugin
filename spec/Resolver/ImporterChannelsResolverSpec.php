<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterChannelsResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;

final class ImporterChannelsResolverSpec extends ObjectBehavior
{
    public function let(ChannelsAssignerInterface $channelsAssigner)
    {
        $this->beConstructedWith($channelsAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterChannelsResolver::class);
    }

    public function it_resolves_channels_for_channels_aware(
        ChannelsAssignerInterface $channelsAssigner,
        ChannelsAwareInterface $channelsAware
    ) {
        $channelsRow = 'channel1, channel2, channel3';
        $channelsCodes = ['channel1', 'channel2', 'channel3'];

        $channelsAssigner->assign($channelsAware, $channelsCodes)->shouldBeCalled();

        $this->resolve($channelsAware, $channelsRow);
    }

    public function it_skips_resolution_when_channels_row_is_null(
        ChannelsAssignerInterface $channelsAssigner,
        ChannelsAwareInterface $channelsAware
    ) {
        $channelsRow = null;

        $channelsAssigner->assign($channelsAware, Argument::any())->shouldNotBeCalled();

        $this->resolve($channelsAware, $channelsRow);
    }
}
