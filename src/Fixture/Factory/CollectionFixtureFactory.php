<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectionTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CollectionFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface              $collectionFactory,
        private FactoryInterface              $collectionTranslationFactory,
        private CollectionRepositoryInterface $collectionRepository,
    ) {
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            /** @var ?CollectionInterface $collection */
            $collection = $this->collectionRepository->findOneBy(['code' => $code]);
            if (
                true === $fields['remove_existing'] &&
                null !== $collection
            ) {
                $this->collectionRepository->remove($collection);
            }

            /** @var CollectionInterface $collection */
            $collection = $this->collectionFactory->createNew();

            $collection->setCode($code);

            foreach ($fields['translations'] as $localeCode => $translation) {
                /** @var CollectionTranslationInterface $collectionTranslation */
                $collectionTranslation = $this->collectionTranslationFactory->createNew();

                $collectionTranslation->setLocale($localeCode);
                $collectionTranslation->setName($translation['name']);

                $collection->addTranslation($collectionTranslation);
            }

            $this->collectionRepository->add($collection);
        }
    }
}
