<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Fixture\Factory;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class CollectionFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $collectionFactory,
        private CollectionRepositoryInterface $collectionRepository,
        private PageRepositoryInterface $pageRepository,
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
            $collection->setName($fields['name']);
            $collection->setType($fields['type']);

            foreach ($fields['page_codes'] as $pageCode) {
                /** @var PageInterface|null $page */
                $page = $this->pageRepository->findOneBy(['code' => $pageCode]);
                if ($page) {
                    $collection->addPage($page);
                }
            }

            $this->collectionRepository->add($collection);
        }
    }
}
