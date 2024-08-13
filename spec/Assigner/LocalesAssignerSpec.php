<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\LocalesAssigner;
use BitBag\SyliusCmsPlugin\Assigner\LocalesAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\LocaleAwareInterface;
use PhpSpec\ObjectBehavior;
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
        LocaleInterface $locale2
    ) {
        $locale1->getCode()->willReturn('en_US');
        $locale2->getCode()->willReturn('fr_FR');

        $localeRepository->findAll()->willReturn([$locale1, $locale2]);

        $localesAware->addLocale($locale1)->shouldBeCalled();
        $localesAware->addLocale($locale2)->shouldBeCalled();

        $this->assign($localesAware, ['en_US', 'fr_FR']);
    }
}
