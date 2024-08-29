<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Assigner\ChannelsAssignerInterface;
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
