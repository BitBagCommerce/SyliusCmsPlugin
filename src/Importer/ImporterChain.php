<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Importer;

final class ImporterChain implements ImporterChainInterface
{
    /** @var ImporterInterface[] */
    private $importers = [];

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
            $resourceCode
        ));
    }
}
