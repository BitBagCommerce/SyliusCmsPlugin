<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Psr\Log\LoggerInterface;
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
