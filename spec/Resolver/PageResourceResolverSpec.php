<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\CmsPlugin\Resolver\PageResourceResolver;
use Sylius\CmsPlugin\Resolver\PageResourceResolverInterface;

final class PageResourceResolverSpec extends ObjectBehavior
{
    public function let(
        PageRepositoryInterface $pageRepository,
        LoggerInterface $logger,
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
        LoggerInterface $logger,
    ) {
        $pageRepository->findOneEnabledByCode('homepage_banner')->willReturn(null);

        $logger
            ->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                'homepage_banner',
            ))
            ->shouldBeCalled()
        ;

        $this->findOrLog('homepage_banner');
    }

    public function it_returns_page_if_found_in_database(
        PageRepositoryInterface $pageRepository,
        PageInterface $page,
    ) {
        $pageRepository->findOneEnabledByCode('homepage_banner')->willReturn($page);

        $this->findOrLog('homepage_banner')->shouldReturn($page);
    }
}
