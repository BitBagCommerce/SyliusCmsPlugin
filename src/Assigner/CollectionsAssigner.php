<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\CollectibleInterface;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Webmozart\Assert\Assert;

final class CollectionsAssigner implements CollectionsAssignerInterface
{
    public function __construct(private CollectionRepositoryInterface $collectionRepository)
    {
    }

    public function assign(CollectibleInterface $collectionsAware, array $collectionsCodes): void
    {
        $collections = $this->collectionRepository->findBy(['code' => $collectionsCodes]);
        Assert::allIsInstanceOf($collections, CollectionInterface::class);

        foreach ($collections as $collection) {
            $collectionsAware->addCollection($collection);
        }
    }
}
