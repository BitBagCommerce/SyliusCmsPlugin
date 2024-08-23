<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\ProductsInTaxonsAwareInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductsInTaxonsAssigner implements ProductsInTaxonsAssignerInterface
{
    public function __construct(private TaxonRepositoryInterface $taxonRepository)
    {
    }

    public function assign(ProductsInTaxonsAwareInterface $productsInTaxonsAware, array $taxonCodes): void
    {
        $taxons = $this->taxonRepository->findBy(['code' => $taxonCodes]);
        Assert::allIsInstanceOf($taxons, TaxonInterface::class);

        foreach ($taxons as $taxon) {
            $productsInTaxonsAware->addProductsInTaxon($taxon);
        }
    }
}
