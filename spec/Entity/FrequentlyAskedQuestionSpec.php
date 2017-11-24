<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestion;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

final class FrequentlyAskedQuestionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(FrequentlyAskedQuestion::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_frequently_asked_question_interface(): void
    {
        $this->shouldHaveType(FrequentlyAskedQuestionInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setCode('delivery_charges_for_orders');
        $this->getCode()->shouldReturn('delivery_charges_for_orders');

        $this->setPosition(2);
        $this->getPosition()->shouldReturn(2);

        $this->setEnabled(true);
        $this->isEnabled()->shouldReturn(true);
    }

    function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }
}
