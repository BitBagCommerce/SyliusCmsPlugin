<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface FrequentlyAskedQuestionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $localeCode
     *
     * @return QueryBuilder
     */
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    /**
     * @param string $localeCode
     *
     * @return array|FrequentlyAskedQuestionInterface[]
     */
    public function findEnabledOrderedByPosition(string $localeCode): array;

    /**
     * @param string $code
     *
     * @return FrequentlyAskedQuestionInterface|null
     */
    public function findOneEnabledByCode(string $code): ?FrequentlyAskedQuestionInterface;
}
