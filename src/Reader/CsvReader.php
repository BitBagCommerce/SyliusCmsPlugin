<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Reader;

use League\Csv\Reader;

final class CsvReader implements ReaderInterface
{
    public function read(string $filePath): \Iterator
    {
        return Reader::createFromPath($filePath)->setHeaderOffset(0)->getIterator();
    }
}
