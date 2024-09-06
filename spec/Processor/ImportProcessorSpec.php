<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Processor;

use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Exception\ImportFailedException;
use Sylius\CmsPlugin\Importer\ImporterChainInterface;
use Sylius\CmsPlugin\Importer\ImporterInterface;
use Sylius\CmsPlugin\Processor\ImportProcessor;
use Sylius\CmsPlugin\Reader\ReaderInterface;

class ImportProcessorSpec extends ObjectBehavior
{
    public function let(
        ImporterChainInterface $importerChain,
        ReaderInterface $reader,
        EntityManagerInterface $entityManager,
    ) {
        $this->beConstructedWith($importerChain, $reader, $entityManager);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImportProcessor::class);
    }

    public function it_processes_import_data(
        ImporterChainInterface $importerChain,
        ReaderInterface $reader,
        EntityManagerInterface $entityManager,
        ImporterInterface $importer,
    ) {
        $resourceCode = 'some_resource';
        $filePath = 'path/to/file.csv';
        $data = [
            ['col1' => 'value1', 'col2' => 'value2'],
            ['col1' => 'value3', 'col2' => 'value4'],
        ];

        $iterator = new \ArrayIterator($data);

        $importerChain->getImporterForResource($resourceCode)->willReturn($importer);
        $reader->read($filePath)->willReturn($iterator);

        $importer->import($data[0])->shouldBeCalled();
        $importer->import($data[1])->shouldBeCalled();

        $entityManager->clear()->shouldBeCalled();
        $importer->cleanup()->shouldBeCalled();

        $this->process($resourceCode, $filePath);
    }

    public function it_throws_exception_when_import_fails(
        ImporterChainInterface $importerChain,
        ReaderInterface $reader,
        EntityManagerInterface $entityManager,
        ImporterInterface $importer,
    ) {
        $resourceCode = 'some_resource';
        $filePath = 'path/to/file.csv';
        $data = [['col1' => 'value1', 'col2' => 'value2']];

        $iterator = new \ArrayIterator($data);
        $importerChain->getImporterForResource($resourceCode)->willReturn($importer);

        $reader->read($filePath)->willReturn($iterator);

        $importer->import($data[0])->willThrow(new \Exception('Import error'));

        $this->shouldThrow(ImportFailedException::class)->during('process', [$resourceCode, $filePath]);
    }
}
