<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Sorter;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Sorter\CollectionsSorter;
use Sylius\CmsPlugin\Sorter\CollectionsSorterInterface;

final class CollectionsSorterSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectionsSorter::class);
    }

    public function it_implements_collections_sorter_interface(): void
    {
        $this->shouldHaveType(CollectionsSorterInterface::class);
    }

    public function it_sorts_collections_with_one_element(
        PageInterface $page,
        CollectionInterface $collection,
    ): void {
        $collection->getCode()->willReturn('COLLECTION_CODE');
        $page->getCollections()->willReturn(new ArrayCollection([$collection->getWrappedObject()]));

        $this->sortByCollections([$page])->shouldReturn(
            [
                'COLLECTION_CODE' => ['collection' => $collection, 0 => $page],
            ],
        );
    }

    public function it_sorts_collections_with_more_elements(
        PageInterface $page1,
        PageInterface $page2,
        PageInterface $page3,
        CollectionInterface $collection1,
        CollectionInterface $collection2,
        CollectionInterface $collection3,
    ): void {
        $collection1->getCode()->willReturn('COLLECTION_1_CODE');
        $collection2->getCode()->willReturn('COLLECTION_2_CODE');
        $collection3->getCode()->willReturn('COLLECTION_3_CODE');

        $page1->getCollections()->willReturn(new ArrayCollection(
            [$collection1->getWrappedObject(), $collection3->getWrappedObject()],
        ));
        $page2->getCollections()->willReturn(new ArrayCollection([$collection3->getWrappedObject()]));
        $page3->getCollections()->willReturn(new ArrayCollection(
            [$collection2->getWrappedObject(), $collection1->getWrappedObject()],
        ));

        $this->sortByCollections([$page1, $page2, $page3])->shouldReturn(
            [
                'COLLECTION_1_CODE' => ['collection' => $collection1, 0 => $page1, 1 => $page3],
                'COLLECTION_3_CODE' => ['collection' => $collection3, 0 => $page1, 1 => $page2],
                'COLLECTION_2_CODE' => ['collection' => $collection2, 0 => $page3],
            ],
        );
    }

    public function it_sorts_collections_with_less_elements(
        PageInterface $page1,
        PageInterface $page2,
        CollectionInterface $collection1,
        CollectionInterface $collection2,
    ): void {
        $collection1->getCode()->willReturn('COLLECTION_1_CODE');
        $collection2->getCode()->willReturn('COLLECTION_2_CODE');

        $page1->getCollections()->willReturn(new ArrayCollection([$collection1->getWrappedObject()]));
        $page2->getCollections()->willReturn(new ArrayCollection([$collection2->getWrappedObject()]));

        $this->sortByCollections([$page1, $page2])->shouldReturn(
            [
                'COLLECTION_1_CODE' => ['collection' => $collection1, 0 => $page1],
                'COLLECTION_2_CODE' => ['collection' => $collection2, 0 => $page2],
            ],
        );
    }
}
