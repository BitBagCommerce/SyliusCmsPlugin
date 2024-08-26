<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
