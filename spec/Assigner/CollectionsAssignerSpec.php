<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
        $collectionRepository->findOneBy(['code' => 'about'])->willReturn($aboutCollection);
        $collectionRepository->findOneBy(['code' => 'blog'])->willReturn($blogCollection);

        $collectionsAware->addCollection($aboutCollection)->shouldBeCalled();
        $collectionsAware->addCollection($blogCollection)->shouldBeCalled();

        $this->assign($collectionsAware, ['about', 'blog']);
    }
}
