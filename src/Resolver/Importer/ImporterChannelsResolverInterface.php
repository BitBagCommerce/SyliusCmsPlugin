<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;

interface ImporterChannelsResolverInterface
{
    public function resolve(ChannelsAwareInterface $channelsAware, ?string $channelsRow): void;
}
