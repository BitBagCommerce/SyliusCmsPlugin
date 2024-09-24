<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Webmozart\Assert\Assert;

final class BlockResourceResolver implements BlockResourceResolverInterface
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private LoggerInterface $logger,
        private ChannelContextInterface $channelContext,
    ) {
    }

    public function findOrLog(string $code): ?BlockInterface
    {
        $channel = $this->channelContext->getChannel();
        Assert::notNull($channel->getCode());
        $block = $this->blockRepository->findEnabledByCode($code, $channel->getCode());

        if (false === $block instanceof BlockInterface) {
            $this->logger->warning(sprintf(
                'Block with "%s" code was not found in the database.',
                $code,
            ));

            return null;
        }

        return $block;
    }
}
