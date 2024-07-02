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
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PageTranslation::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_page_translation_interface(): void
    {
        $this->shouldHaveType(PageTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    public function it_allows_access_via_properties(MediaInterface $pageImage): void
    {
        $this->setSlug('homepage');
        $this->getSlug()->shouldReturn('homepage');

        $this->setMetaKeywords('homepage');
        $this->getMetaKeywords()->shouldReturn('homepage');

        $this->setMetaDescription('Description');
        $this->getMetaDescription()->shouldReturn('Description');

        $this->setTitle('title');
        $this->getTitle()->shouldReturn('title');
    }
}
