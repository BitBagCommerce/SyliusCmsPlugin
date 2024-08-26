<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Renderer\Collection\CollectionMediaRenderer;
use Sylius\CmsPlugin\Renderer\Collection\CollectionRendererInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;

final class CollectionMediaRendererSpec extends ObjectBehavior
{
    function let(RenderMediaRuntimeInterface $renderMediaRuntime)
    {
        $this->beConstructedWith($renderMediaRuntime);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CollectionMediaRenderer::class);
        $this->shouldImplement(CollectionRendererInterface::class);
    }

    function it_renders_media_collection(RenderMediaRuntimeInterface $renderMediaRuntime, CollectionInterface $collection, MediaInterface $media1, MediaInterface $media2)
    {
        $media1->getId()->willReturn(1);
        $media2->getId()->willReturn(2);

        $media1->getCode()->willReturn('media_code_1');
        $media2->getCode()->willReturn('media_code_2');

        $collection->getMedia()->willReturn(new ArrayCollection([$media1->getWrappedObject(), $media2->getWrappedObject()]));

        $renderMediaRuntime->renderMedia('media_code_1')->willReturn('media1');
        $renderMediaRuntime->renderMedia('media_code_2')->willReturn('media2');

        $this->render($collection)->shouldReturn('media1media2');
    }

    function it_renders_limited_number_of_media(RenderMediaRuntimeInterface $renderMediaRuntime, CollectionInterface $collection, MediaInterface $media1, MediaInterface $media2)
    {
        $media1->getId()->willReturn(1);
        $media2->getId()->willReturn(2);

        $media1->getCode()->willReturn('media_code_1');
        $media2->getCode()->willReturn('media_code_2');

        $collection->getMedia()->willReturn(new ArrayCollection([$media1->getWrappedObject(), $media2->getWrappedObject()]));

        $renderMediaRuntime->renderMedia('media_code_1')->willReturn('media1');

        $this->render($collection, 1)->shouldReturn('media1');
    }

    function it_supports_collections_with_media(CollectionInterface $collection, MediaInterface $media1)
    {
        $collection->getMedia()->willReturn(new ArrayCollection([$media1]));

        $this->supports($collection)->shouldReturn(true);
    }

    function it_does_not_support_collections_without_media(CollectionInterface $collection)
    {
        $collection->getMedia()->willReturn(new ArrayCollection());

        $this->supports($collection)->shouldReturn(false);
    }
}
