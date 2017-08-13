<?php

namespace BitBag\CmsPlugin\Exception;

class BlockNotFoundException extends \Exception
{
    public function __construct($code)
    {
        parent::__construct(sprintf("Block for %s code was not found.", $code));
    }
}