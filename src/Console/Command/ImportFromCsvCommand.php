<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Console\Command;

use Sylius\CmsPlugin\Processor\ImportProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ImportFromCsvCommand extends Command
{
    public function __construct(private ImportProcessorInterface $importProcessor)
    {
        parent::__construct();
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
        $io = new SymfonyStyle($input, $output);
        $resourceName = $input->getArgument('resource');
        $file = $input->getArgument('file');

        $io->title('Importing resources...');

        $this->importProcessor->process($resourceName, $file);

        $io->success('Resources imported successfully.');

        return Command::SUCCESS;
    }
}
