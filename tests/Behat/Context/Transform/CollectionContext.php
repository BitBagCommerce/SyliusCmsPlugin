<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Webmozart\Assert\Assert;

final class CollectionContext implements Context
{
    public function __construct(
        private CollectionRepositoryInterface $collectionRepository,
        private string                        $locale = 'en_US',
    ) {
    }

    /**
     * @Transform /^collection(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" collection(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :collection
     */
    public function getCollectionByCode(string $collectionCode): CollectionInterface
    {
        $collection = $this->collectionRepository->findOneByCode($collectionCode, $this->locale);

        Assert::notNull(
            $collection,
            sprintf('No collections has been found with code "%s".', $collectionCode),
        );

        return $collection;
    }
}
