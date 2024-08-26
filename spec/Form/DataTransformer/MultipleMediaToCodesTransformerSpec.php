<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Form\DataTransformer\MultipleMediaToCodesTransformer;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;

final class MultipleMediaToCodesTransformerSpec extends ObjectBehavior
{
    public function let(MediaRepositoryInterface $mediaRepository): void
    {
        $this->beConstructedWith($mediaRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MultipleMediaToCodesTransformer::class);
    }

    public function it_transforms_null_value_to_empty_collection(): void
    {
        $this->transform(null)->shouldBeAnInstanceOf(ArrayCollection::class);
        $this->transform(null)->count()->shouldBe(0);
    }

    public function it_transforms_empty_array_to_empty_collection(): void
    {
        $this->transform([])->shouldBeAnInstanceOf(ArrayCollection::class);
        $this->transform([])->count()->shouldBe(0);
    }

    public function it_transforms_non_empty_array_to_collection(
        MediaRepositoryInterface $mediaRepository,
        MediaInterface $media1,
        MediaInterface $media2,
    ): void {
        $mediaCodes = ['code1', 'code2'];
        $mediaRepository->findBy(['code' => $mediaCodes])->willReturn([$media1, $media2]);

        $this->transform($mediaCodes)->shouldBeAnInstanceOf(ArrayCollection::class);
        $this->transform($mediaCodes)->shouldHaveCount(2);
        $this->transform($mediaCodes)->toArray()->shouldBe([$media1, $media2]);
    }

    public function it_reverse_transforms_empty_collection_to_empty_array(): void
    {
        $collection = new ArrayCollection();
        $this->reverseTransform($collection)->shouldBeArray();
        $this->reverseTransform($collection)->shouldBe([]);
    }

    public function it_reverse_transforms_collection_to_array_of_media_codes(
        MediaInterface $media1,
        MediaInterface $media2,
    ): void {
        $media1->getCode()->willReturn('code1');
        $media2->getCode()->willReturn('code2');

        $collection = new ArrayCollection([$media1->getWrappedObject(), $media2->getWrappedObject()]);

        $this->reverseTransform($collection)->shouldBe(['code1', 'code2']);
    }
}
