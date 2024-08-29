<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Processor;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\CmsPlugin\Exception\ImportFailedException;
use Sylius\CmsPlugin\Importer\ImporterChainInterface;
use Sylius\CmsPlugin\Reader\ReaderInterface;

final class ImportProcessor implements ImportProcessorInterface
{
    public function __construct(
        private ImporterChainInterface $importerChain,
        private ReaderInterface $reader,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(string $resourceName, string $filePath): void
    {
        $importer = $this->importerChain->getImporterForResource($resourceName);
        $data = $this->reader->read($filePath);

        foreach ($data as $index => $row) {
            try {
                $importer->import($row);
            } catch (\Exception $exception) {
                ++$index;

                throw new ImportFailedException($exception->getMessage(), $index);
            }

            $this->entityManager->clear();
        }

        $importer->cleanup();
    }
}
