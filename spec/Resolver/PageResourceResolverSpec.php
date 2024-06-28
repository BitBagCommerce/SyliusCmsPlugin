<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
    public function let(
        PageRepositoryInterface $pageRepository,
        LoggerInterface $logger
    ) {
        $this->beConstructedWith($pageRepository, $logger);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PageResourceResolver::class);
    }

    public function it_implements_page_resource_resolver_interface(): void
    {
        $this->shouldHaveType(PageResourceResolverInterface::class);
    }

    public function it_logs_warning_if_page_was_not_found(
        PageRepositoryInterface $pageRepository,
        LoggerInterface $logger
    ) {
        $pageRepository->findOneEnabledByCode('homepage_banner')->willReturn(null);

        $logger
            ->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                'homepage_banner'
            ))
            ->shouldBeCalled()
        ;

        $this->findOrLog('homepage_banner');
    }

    public function it_returns_page_if_found_in_database(
        PageRepositoryInterface $pageRepository,
        PageInterface $page
    ) {
        $pageRepository->findOneEnabledByCode('homepage_banner')->willReturn($page);

        $this->findOrLog('homepage_banner')->shouldReturn($page);
    }
}
