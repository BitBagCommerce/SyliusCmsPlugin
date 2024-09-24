<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Webmozart\Assert\Assert;

final class ChannelsAssigner implements ChannelsAssignerInterface
{
    public function __construct(private ChannelRepositoryInterface $channelRepository)
    {
    }

    public function assign(ChannelsAwareInterface $channelsAware, array $channelsCodes): void
    {
        $channels = $this->channelRepository->findBy(['code' => $channelsCodes]);
        Assert::allIsInstanceOf($channels, ChannelInterface::class);

        foreach ($channels as $channel) {
            $channelsAware->addChannel($channel);
        }
    }
}
