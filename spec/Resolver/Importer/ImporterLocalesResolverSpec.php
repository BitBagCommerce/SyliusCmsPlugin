<?php

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
