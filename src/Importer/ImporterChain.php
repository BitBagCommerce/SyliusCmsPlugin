<?php

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
