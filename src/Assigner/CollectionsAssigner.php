<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
