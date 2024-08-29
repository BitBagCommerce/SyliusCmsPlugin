<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;

trait TranslationBasedAwareTrait
{
    protected function createTranslationBasedQueryBuilder(?string $locale = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation')
        ;

        if (null !== $locale) {
            $queryBuilder
                ->andWhere('translation.locale = :locale')
                ->setParameter('locale', $locale)
            ;
        }

        return $queryBuilder;
    }
}
