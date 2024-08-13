<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver\Importer;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;

final class ImporterChannelsResolver implements ImporterChannelsResolverInterface
{
    public function __construct(private ChannelsAssignerInterface $channelsAssigner)
    {
    }

    public function resolve(ChannelsAwareInterface $channelsAware, ?string $channelsRow): void
    {
        if (null === $channelsRow) {
            return;
        }

        $channelsCodes = explode(',', $channelsRow);
        $channelsCodes = array_map(static function (string $element): string {
            return trim($element);
        }, $channelsCodes);

        $this->channelsAssigner->assign($channelsAware, $channelsCodes);
    }
}
