<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Command;

use BitBag\SyliusCmsPlugin\Processor\ImportProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportFromCsvCommand extends Command
{
    /** @var ImportProcessorInterface */
    private $importProcessor;

    public function __construct(ImportProcessorInterface $importProcessor)
    {
        parent::__construct();

        $this->importProcessor = $importProcessor;
    }

    protected function configure(): void
    {
        $this
            ->setName('bitbag:import:csv')
            ->setDescription('Imports a resource')
            ->setHelp('This command allows you to import resources from CSV. It takes file path and resource name as parameter.')
            ->addArgument('resource', InputArgument::REQUIRED, 'Importer resource name.')
            ->addArgument('file', InputArgument::REQUIRED, 'CSV file path.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resourceName = $input->getArgument('resource');
        $file = $input->getArgument('file');

        $this->importProcessor->process($resourceName, $file);
        return self::SUCCESS;
    }
}
