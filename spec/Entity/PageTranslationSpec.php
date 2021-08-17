<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslation;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

final class PageTranslationSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageTranslation::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_page_translation_interface(): void
    {
        $this->shouldHaveType(PageTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    function it_allows_access_via_properties(MediaInterface $pageImage): void
    {
        $this->setName('Homepage');
        $this->getName()->shouldReturn('Homepage');

        $this->setSlug('homepage');
        $this->getSlug()->shouldReturn('homepage');

        $this->setContent('<h1>Homepage</h1>');
        $this->getContent()->shouldReturn('<h1>Homepage</h1>');

        $this->setMetaKeywords('homepage');
        $this->getMetaKeywords()->shouldReturn('homepage');

        $this->setMetaDescription('Description');
        $this->getMetaDescription()->shouldReturn('Description');

        $this->setImage($pageImage);
        $this->getImage()->shouldReturn($pageImage);

        $this->setNameWhenLinked('name linked');
        $this->getNameWhenLinked()->shouldReturn('name linked');

        $this->setBreadcrumb('name breadcrumb');
        $this->getBreadcrumb()->shouldReturn('name breadcrumb');

        $this->setDescriptionWhenLinked('description linked');
        $this->getDescriptionWhenLinked()->shouldReturn('description linked');

        $this->setTitle('title');
        $this->getTitle()->shouldReturn('title');
    }
}
