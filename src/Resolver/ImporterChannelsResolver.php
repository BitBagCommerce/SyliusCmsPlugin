<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

final class ImporterChannelsResolver implements ImporterChannelsResolverInterface
{
    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function resolve(ChannelsAwareInterface $channelsAware, ?string $channelsRow): void
    {
        if (null === $channelsRow) {
            return;
        }

        $channelCodes = explode(',', $channelsRow);
        $channelCodes = array_map(function (string $element): string {
            return trim($element);
        }, $channelCodes);

        foreach ($channelCodes as $channelCode) {
            /** @var ChannelInterface $channel */
            $channel = $this->channelRepository->findOneBy(['code' => $channelCode]);

            if (null !== $channel) {
                $channelsAware->addChannel($channel);
            }
        }
    }
}
