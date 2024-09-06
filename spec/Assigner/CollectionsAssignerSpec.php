<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Assigner;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Assigner\CollectionsAssigner;
use Sylius\CmsPlugin\Assigner\CollectionsAssignerInterface;
use Sylius\CmsPlugin\Entity\CollectibleInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;

final class CollectionsAssignerSpec extends ObjectBehavior
{
    public function let(CollectionRepositoryInterface $collectionRepository): void
    {
        $this->beConstructedWith($collectionRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectionsAssigner::class);
    }

    public function it_implements_collections_assigner_interface(): void
    {
        $this->shouldHaveType(CollectionsAssignerInterface::class);
    }

    public function it_assigns_collections(
        CollectionRepositoryInterface $collectionRepository,
        CollectionInterface $aboutCollection,
        CollectionInterface $blogCollection,
        CollectibleInterface $collectionsAware,
    ): void {
        $collectionRepository->findBy(['code' => ['about', 'blog']])->willReturn([$aboutCollection, $blogCollection]);

        $collectionsAware->addCollection($aboutCollection)->shouldBeCalled();
        $collectionsAware->addCollection($blogCollection)->shouldBeCalled();

        $this->assign($collectionsAware, ['about', 'blog']);
    }
}
