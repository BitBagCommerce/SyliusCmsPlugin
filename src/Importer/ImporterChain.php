<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

final class ImporterChain implements ImporterChainInterface
{
    /** @var ImporterInterface[] */
    private array $importers = [];

    public function addImporter(ImporterInterface $importer): void
    {
        $this->importers[] = $importer;
    }

    public function getImporterForResource(string $resourceCode): ImporterInterface
    {
        foreach ($this->importers as $importer) {
            if ($resourceCode === $importer->getResourceCode()) {
                return $importer;
            }
        }

        throw new \UnexpectedValueException(sprintf(
            'Importer for %s resource was not found. Make sure getResourceCode in the importer returns proper resource name',
            $resourceCode,
        ));
    }
}
