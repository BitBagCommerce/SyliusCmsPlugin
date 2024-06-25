<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\CollectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectibleInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterCollectionsResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ImporterCollectionsResolverSpec extends ObjectBehavior
{
    public function let(CollectionsAssignerInterface $collectionsAssigner)
    {
        $this->beConstructedWith($collectionsAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterCollectionsResolver::class);
    }

    public function it_resolves_collections_for_collectionable_entity(
        CollectionsAssignerInterface $collectionsAssigner,
        CollectibleInterface $collectionable
    ) {
        $collectionsRow = 'collection1, collection2, collection3';
        $collectionsCodes = ['collection1', 'collection2', 'collection3'];

        $collectionsAssigner->assign($collectionable, $collectionsCodes)->shouldBeCalled();

        $this->resolve($collectionable, $collectionsRow);
    }

    public function it_skips_resolution_when_collections_row_is_null(
        CollectionsAssignerInterface $collectionsAssigner,
        CollectibleInterface $collectionable
    )
    {
        $collectionsRow = null;

        $collectionsAssigner->assign($collectionable, Argument::any())->shouldNotBeCalled();

        $this->resolve($collectionable, $collectionsRow);
    }
}
