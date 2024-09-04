<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver\Importer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\CmsPlugin\Assigner\CollectionsAssignerInterface;
use Sylius\CmsPlugin\Entity\CollectibleInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolver;

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
        CollectibleInterface $collectionable,
    ) {
        $collectionsRow = 'collection1, collection2, collection3';
        $collectionsCodes = ['collection1', 'collection2', 'collection3'];

        $collectionsAssigner->assign($collectionable, $collectionsCodes)->shouldBeCalled();

        $this->resolve($collectionable, $collectionsRow);
    }

    public function it_skips_resolution_when_collections_row_is_null(
        CollectionsAssignerInterface $collectionsAssigner,
        CollectibleInterface $collectionable,
    ) {
        $collectionsRow = null;

        $collectionsAssigner->assign($collectionable, Argument::any())->shouldNotBeCalled();

        $this->resolve($collectionable, $collectionsRow);
    }
}
