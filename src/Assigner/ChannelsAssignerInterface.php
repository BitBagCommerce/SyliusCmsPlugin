<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;

interface ChannelsAssignerInterface
{
    public function assign(ChannelsAwareInterface $channelsAware, array $channelsCodes): void;
}
