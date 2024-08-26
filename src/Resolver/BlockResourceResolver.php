<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver;

use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class BlockResourceResolver implements BlockResourceResolverInterface
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private LoggerInterface $logger,
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
        private RepositoryInterface $localeRepository,
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

        /** @var LocaleInterface $locale */
        $locale = $this->localeRepository->findOneBy(['code' => $this->localeContext->getLocaleCode()]);
        Assert::notNull($locale);

        if (false === $block->hasLocale($locale) && 0 !== $block->getLocales()->count()) {
            $this->logger->warning(sprintf(
                'Block with "%s" code was found in the database, but it does not have "%s" locale.',
                $code,
                $this->localeContext->getLocaleCode(),
            ));

            return null;
        }

        return $block;
    }
}
