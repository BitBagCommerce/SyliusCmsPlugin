<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver\Importer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\CmsPlugin\Assigner\ChannelsAssignerInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterChannelsResolver;
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
        ChannelsAwareInterface $channelsAware,
    ) {
        $channelsRow = 'channel1, channel2, channel3';
        $channelsCodes = ['channel1', 'channel2', 'channel3'];

        $channelsAssigner->assign($channelsAware, $channelsCodes)->shouldBeCalled();

        $this->resolve($channelsAware, $channelsRow);
    }

    public function it_skips_resolution_when_channels_row_is_null(
        ChannelsAssignerInterface $channelsAssigner,
        ChannelsAwareInterface $channelsAware,
    ) {
        $channelsRow = null;

        $channelsAssigner->assign($channelsAware, Argument::any())->shouldNotBeCalled();

        $this->resolve($channelsAware, $channelsRow);
    }
}
