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

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;

final class ImporterChannelsResolver implements ImporterChannelsResolverInterface
{
    /** @var ChannelsAssignerInterface */
    private $channelsAssigner;

    public function __construct(ChannelsAssignerInterface $channelsAssigner)
    {
        $this->channelsAssigner = $channelsAssigner;
    }

    public function resolve(ChannelsAwareInterface $channelsAware, ?string $channelsRow): void
    {
        if (null === $channelsRow) {
            return;
        }

        $channelsCodes = explode(',', $channelsRow);
        $channelsCodes = array_map(function (string $element): string {
            return trim($element);
        }, $channelsCodes);

        $this->channelsAssigner->assign($channelsAware, $channelsCodes);
    }
}
