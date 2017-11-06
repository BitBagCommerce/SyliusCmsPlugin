<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\CmsPlugin\Twig\Extension;

use BitBag\CmsPlugin\Entity\PageInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use BitBag\CmsPlugin\Twig\Extension\RenderPageLinkByCodeExtension;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class RenderPageLinkByCodeExtensionSpec extends ObjectBehavior
{
    function let(
        PageRepositoryInterface $pageRepository,
        LoggerInterface $logger
    ): void
    {
        $this->beConstructedWith($pageRepository, $logger);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderPageLinkByCodeExtension::class);
    }

    function it_extends_twig_extension(): void
    {
        $this->shouldHaveType(\Twig_Extension::class);
    }

    function it_returns_functions(): void
    {
        $functions = $this->getFunctions();
        $functions->shouldHaveCount(1);

        foreach ($functions as $function) {
            $function->shouldHaveType(\Twig_SimpleFunction::class);
        }
    }

    function it_renders_page_link(
        PageRepositoryInterface $pageRepository,
        PageInterface $page,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $pageRepository->findEnabledByCode('bitbag')->willReturn($page);
        $twigEnvironment->render('BitBagCmsPlugin:Shop:Page:_link.html.twig', ['page' => $page])->shouldBeCalled();

        $this->renderPageLinkByCode($twigEnvironment, 'bitbag');
    }

    function it_adds_warning_for_not_found_page(
        PageRepositoryInterface $pageRepository,
        LoggerInterface $logger,
        \Twig_Environment $twigEnvironment
    ): void
    {
        $pageRepository->findEnabledByCode('bitbag')->willReturn(null);
        $logger->warning('Page with "bitbag" code was not found in the database.')->shouldBeCalled();

        $this->renderPageLinkByCode($twigEnvironment, 'bitbag')->shouldReturn(null);
    }
}
