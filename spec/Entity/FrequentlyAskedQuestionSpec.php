<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestion;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class FrequentlyAskedQuestionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FrequentlyAskedQuestion::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_frequently_asked_question_interface(): void
    {
        $this->shouldHaveType(FrequentlyAskedQuestionInterface::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->setCode('delivery_charges_for_orders');
        $this->getCode()->shouldReturn('delivery_charges_for_orders');

        $this->setPosition(2);
        $this->getPosition()->shouldReturn(2);

        $this->setEnabled(true);
        $this->isEnabled()->shouldReturn(true);
    }

    public function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }

    public function it_associates_channels(ChannelInterface $firstChannel, ChannelInterface $secondChannel): void
    {
        $this->addChannel($firstChannel);
        $this->hasChannel($firstChannel)->shouldReturn(true);

        $this->hasChannel($secondChannel)->shouldReturn(false);

        $this->removeChannel($firstChannel);

        $this->hasChannel($firstChannel)->shouldReturn(false);
    }
}
