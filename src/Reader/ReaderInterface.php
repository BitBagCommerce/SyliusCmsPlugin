<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Reader;

interface ReaderInterface
{
    public function read(string $filePath): \Iterator;
}
