<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\TaxonAwareInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Webmozart\Assert\Assert;

final class TaxonsAssigner implements TaxonsAssignerInterface
{
    public function __construct(private TaxonRepositoryInterface $taxonRepository)
    {
    }

    public function assign(TaxonAwareInterface $taxonAware, array $taxonCodes): void
    {
        foreach ($taxonCodes as $taxonCode) {
            /** @var TaxonInterface|null $taxon */
            $taxon = $this->taxonRepository->findOneBy(['code' => $taxonCode]);

            Assert::notNull($taxon, sprintf('Taxon with %s code not found.', $taxonCode));
            $taxonAware->addTaxon($taxon);
        }
    }
}
