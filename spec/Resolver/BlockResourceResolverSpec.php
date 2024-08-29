<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\CmsPlugin\Resolver\BlockResourceResolver;
use Sylius\CmsPlugin\Resolver\BlockResourceResolverInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class BlockResourceResolverSpec extends ObjectBehavior
{
    public function let(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext,
        RepositoryInterface $localeRepository,
    ) {
        $this->beConstructedWith($blockRepository, $logger, $channelContext, $localeContext, $localeRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BlockResourceResolver::class);
    }

    public function it_implements_block_resource_resolver_interface(): void
    {
        $this->shouldHaveType(BlockResourceResolverInterface::class);
    }

    public function it_logs_warning_if_block_was_not_found(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
    ) {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $blockRepository->findEnabledByCode('homepage_banner', 'WEB')->willReturn(null);

        $logger
            ->warning(sprintf(
                'Block with "%s" code was not found in the database.',
                'homepage_banner',
            ))
            ->shouldBeCalled()
        ;

        $this->findOrLog('homepage_banner');
    }

    public function it_logs_warning_if_block_was_found_but_it_does_not_have_locale(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        LocaleContextInterface $localeContext,
        LocaleInterface $locale,
        RepositoryInterface $localeRepository,
        BlockInterface $block,
    ) {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $blockRepository->findEnabledByCode('homepage_banner', 'WEB')->willReturn($block);
        $localeContext->getLocaleCode()->willReturn('en_US');
        $locale->getCode()->willReturn('en_US');
        $localeRepository->findOneBy(['code' => 'en_US'])->willReturn($locale);
        $block->hasLocale($locale)->willReturn(false);
        $block->getLocales()->willReturn(new ArrayCollection(['pl_PL']));

        $logger
            ->warning(sprintf(
                'Block with "%s" code was found in the database, but it does not have "%s" locale.',
                'homepage_banner',
                'en_US',
            ))
            ->shouldBeCalled()
        ;

        $this->findOrLog('homepage_banner');
    }

    public function it_returns_block_if_found_in_database(
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        LocaleContextInterface $localeContext,
        LocaleInterface $locale,
        RepositoryInterface $localeRepository,
    ) {
        $channel->getCode()->willReturn('WEB');
        $channelContext->getChannel()->willReturn($channel);
        $blockRepository->findEnabledByCode('homepage_banner', 'WEB')->willReturn($block);
        $localeContext->getLocaleCode()->willReturn('en_US');
        $locale->getCode()->willReturn('en_US');
        $localeRepository->findOneBy(['code' => 'en_US'])->willReturn($locale);
        $block->hasLocale($locale)->willReturn(true);

        $this->findOrLog('homepage_banner')->shouldReturn($block);
    }
}
