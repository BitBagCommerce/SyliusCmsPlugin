<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

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
