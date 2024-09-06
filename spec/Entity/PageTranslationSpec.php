<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Entity;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Entity\PageTranslation;
use Sylius\CmsPlugin\Entity\PageTranslationInterface;
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
