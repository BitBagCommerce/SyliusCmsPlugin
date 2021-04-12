<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Webmozart\Assert\Assert;

final class ChannelsAssigner implements ChannelsAssignerInterface
{
    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function assign(ChannelsAwareInterface $channelsAware, array $channelsCodes): void
    {
        foreach ($channelsCodes as $channelCode) {
            /** @var ChannelInterface $channel|null */
            $channel = $this->channelRepository->findOneBy(['code' => $channelCode]);

            Assert::notNull($channel, sprintf('Channel with %s code not found.', $channelCode));
            $channelsAware->addChannel($channel);
        }
    }
}
