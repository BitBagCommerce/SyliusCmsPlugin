<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\PageResourceResolver;
use BitBag\SyliusCmsPlugin\Resolver\PageResourceResolverInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class PageResourceResolverSpec extends ObjectBehavior
{
    function let(PageRepositoryInterface $pageRepository, LocaleContextInterface $localeContext, LoggerInterface $logger)
    {
        $this->beConstructedWith($pageRepository, $localeContext, $logger);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageResourceResolver::class);
    }

    function it_implements_page_resource_resolver_interface(): void
    {
        $this->shouldHaveType(PageResourceResolverInterface::class);
    }

    function it_logs_warning_if_page_was_not_found(
        PageRepositoryInterface $pageRepository,
        LocaleContextInterface $localeContext,
        LoggerInterface $logger
    )
    {
        $localeContext->getLocaleCode()->willReturn('en_US');
        $pageRepository->findOneEnabledByCode('homepage_banner', 'en_US')->willReturn(null);

        $logger
            ->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                'homepage_banner'
            ))
            ->shouldBeCalled()
        ;

        $this->findOrLog('homepage_banner');
    }

    function it_returns_page_if_found_in_database(
        PageRepositoryInterface $pageRepository,
        LocaleContextInterface $localeContext,
        PageInterface $page
    )
    {
        $localeContext->getLocaleCode()->willReturn('en_US');
        $pageRepository->findOneEnabledByCode('homepage_banner', 'en_US')->willReturn($page);

        $this->findOrLog('homepage_banner')->shouldReturn($page);
    }
}
