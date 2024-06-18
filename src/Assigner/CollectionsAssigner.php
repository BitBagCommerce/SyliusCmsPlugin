<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\CollectionableInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Webmozart\Assert\Assert;

final class CollectionsAssigner implements CollectionsAssignerInterface
{
    public function __construct(private CollectionRepositoryInterface $collectionRepository)
    {
    }

    public function assign(CollectionableInterface $collectionsAware, array $collectionsCodes): void
    {
        foreach ($collectionsCodes as $collectionCode) {
            /** @var CollectionInterface|null $collection */
            $collection = $this->collectionRepository->findOneBy(['code' => $collectionCode]);

            Assert::notNull($collection, sprintf('Collection with %s code not found.', $collectionCode));
            $collectionsAware->addCollection($collection);
        }
    }
}
