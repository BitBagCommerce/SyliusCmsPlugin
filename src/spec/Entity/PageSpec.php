<?php

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\Page;
use BitBag\CmsPlugin\Entity\PageInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

class PageSpec extends ObjectBehavior
{
    const SLUG = 'Slug';
    const METAKEYWORDS = 'php, js, jquery';
    const METADESCRIPTION = 'This is what You get.';
    const CONTENT = 'Some of the content.';


    function it_is_initializable()
    {
        $this->shouldHaveType(Page::class);
        $this->shouldHaveType(PageInterface::class);
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_allows_access_via_properties()
    {
        $this->setSlug(self::SLUG);
        $this->getSlug()->shouldReturn('Slug');

        $this->setMetaKeywords(self::METAKEYWORDS);
        $this->getMetaKeywords()->shouldReturn('php, js, jquery');

        $this->setMetaDescription(self::METADESCRIPTION);
        $this->getMetaDescription()->shouldReturn('This is what You get.');

        //$this->getPageTranslation()->setLocale('en')->setContent(self::CONTENT);
        //$this->getContent()->shouldReturn('Some of the content.');
    }
}
