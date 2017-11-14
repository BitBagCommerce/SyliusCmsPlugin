<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Repository;

use BitBag\CmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
interface FrequentlyAskedQuestionRepositoryInterface extends RepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function createListQueryBuilder(): QueryBuilder;

    /**
     * @param string $localeCode
     *
     * @return array|FrequentlyAskedQuestionInterface[]
     */
    public function findEnabledOrderedByPosition(string $localeCode): array;

    /**
     * @param string $code
     *
     * @return null|FrequentlyAskedQuestionInterface
     */
    public function findOneEnabledByCode(string $code): ?FrequentlyAskedQuestionInterface;
}
