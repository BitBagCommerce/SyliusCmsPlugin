<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Processor;

use BitBag\SyliusCmsPlugin\Exception\ImportFailedException;
use BitBag\SyliusCmsPlugin\Importer\ImporterChainInterface;
use BitBag\SyliusCmsPlugin\Reader\ReaderInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ImportProcessor implements ImportProcessorInterface
{
    /** @var ImporterChainInterface */
    private $importerChain;

    /** @var ReaderInterface */
    private $reader;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ImporterChainInterface $importerChain,
        ReaderInterface $reader,
        EntityManagerInterface $entityManager
    ) {
        $this->importerChain = $importerChain;
        $this->reader = $reader;
        $this->entityManager = $entityManager;
    }

    public function process(string $resourceCode, string $filePath): void
    {
        $importer = $this->importerChain->getImporterForResource($resourceCode);
        $data = $this->reader->read($filePath);

        foreach ($data as $index => $row) {
            try {
                $importer->import($row);
            } catch (\Exception $exception) {
                throw new ImportFailedException($exception->getMessage(), ++$index);
            }

            $this->entityManager->clear();
        }

        $importer->cleanup();
    }
}
