<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class CollectionContext implements Context
{
    public function __construct(
        private SharedStorageInterface         $sharedStorage,
        private RandomStringGeneratorInterface $randomStringGenerator,
        private FactoryInterface               $collectionFactory,
        private CollectionRepositoryInterface  $collectionRepository,
    ) {
    }

    /**
     * @Given there is a collection in the store
     */
    public function thereIsAnExistingCollection(): void
    {
        $collection = $this->createCollection();

        $this->saveCollection($collection);
    }

    /**
     * @Given there are existing collections named :firstNameCollection and :secondNameCollection
     */
    public function thereAreExistingCollections(string ...$collectionsNames): void
    {
        foreach ($collectionsNames as $collectionName) {
            $collection = $this->createCollection(null, $collectionName);

            $this->saveCollection($collection);
        }
    }

    /**
     * @Given there is an existing collection with :code code
     */
    public function thereIsAnExistingCollectionWithCode(string $code): void
    {
        $collection = $this->createCollection($code);

        $this->saveCollection($collection);
    }

    /**
     * @Given there is a :collectionName collection in the store
     */
    public function thereIsACollectionInTheStore(string $collectionName): void
    {
        $collection = $this->createCollection(strtolower(StringInflector::nameToCode($collectionName)), $collectionName);

        $this->saveCollection($collection);
    }

    private function createCollection(?string $code = null, string $name = null): CollectionInterface
    {
        /** @var CollectionInterface $collection */
        $collection = $this->collectionFactory->createNew();

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $name) {
            $name = $this->randomStringGenerator->generate();
        }

        $collection->setCode($code);
        $collection->setCurrentLocale('en_US');
        $collection->setName($name);

        return $collection;
    }

    private function saveCollection(CollectionInterface $collection): void
    {
        $this->collectionRepository->add($collection);
        $this->sharedStorage->set('collection', $collection);
    }
}
