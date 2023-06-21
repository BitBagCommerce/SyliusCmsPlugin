<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Processor;

use BitBag\SyliusCmsPlugin\Exception\ImportFailedException;
use BitBag\SyliusCmsPlugin\Importer\ImporterChainInterface;
use BitBag\SyliusCmsPlugin\Reader\ReaderInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ImportProcessor implements ImportProcessorInterface
{
    public function __construct(
        private ImporterChainInterface $importerChain,
        private ReaderInterface $reader,
        private EntityManagerInterface $entityManager,
        ) {
    }

    public function process(string $resourceCode, string $filePath): void
    {
        $importer = $this->importerChain->getImporterForResource($resourceCode);
        $data = $this->reader->read($filePath);

        foreach ($data as $index => $row) {
            try {
                $importer->import($row);
            } catch (\Exception $exception) {
                $index += 1;

                throw new ImportFailedException($exception->getMessage(), $index);
            }

            $this->entityManager->clear();
        }

        $importer->cleanup();
    }
}
