<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Assigner;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\LocalesAssigner;
use Sylius\CmsPlugin\Assigner\LocalesAssignerInterface;
use Sylius\CmsPlugin\Entity\LocaleAwareInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class LocalesAssignerSpec extends ObjectBehavior
{
    public function let(RepositoryInterface $localeRepository)
    {
        $this->beConstructedWith($localeRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LocalesAssigner::class);
    }

    public function it_implements_locales_assigner_interface()
    {
        $this->shouldImplement(LocalesAssignerInterface::class);
    }

    public function it_assigns_locales_to_locale_aware_entity(
        RepositoryInterface $localeRepository,
        LocaleAwareInterface $localesAware,
        LocaleInterface $locale1,
        LocaleInterface $locale2,
    ) {
        $locale1->getCode()->willReturn('en_US');
        $locale2->getCode()->willReturn('fr_FR');

        $localeRepository->findBy(['code' => ['en_US', 'fr_FR']])->willReturn([$locale1, $locale2]);

        $localesAware->addLocale($locale1)->shouldBeCalled();
        $localesAware->addLocale($locale2)->shouldBeCalled();

        $this->assign($localesAware, ['en_US', 'fr_FR']);
    }
}
