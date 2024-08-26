<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver\Importer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\LocalesAssignerInterface;
use Sylius\CmsPlugin\Entity\LocaleAwareInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterLocalesResolver;

final class ImporterLocalesResolverSpec extends ObjectBehavior
{
    public function let(LocalesAssignerInterface $localesAssigner)
    {
        $this->beConstructedWith($localesAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterLocalesResolver::class);
    }

    public function it_resolves_locales_for_locale_aware_entity(
        LocalesAssignerInterface $localesAssigner,
        LocaleAwareInterface $localesAware,
    ) {
        $localesRow = 'en_US, fr_FR';
        $localesAssigner->assign($localesAware, ['en_US', 'fr_FR'])->shouldBeCalled();

        $this->resolve($localesAware, $localesRow);
    }

    public function it_does_not_assign_locales_when_locales_row_is_empty(
        LocalesAssignerInterface $localesAssigner,
        LocaleAwareInterface $localesAware,
    ) {
        $localesAssigner->assign($localesAware, [])->shouldNotBeCalled();

        $this->resolve($localesAware, '');
    }
}
