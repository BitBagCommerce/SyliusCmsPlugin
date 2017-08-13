<?php

namespace BitBag\CmsPlugin\Exception;

class TemplateTypeNotFound extends \Exception
{
    public function __construct($type)
    {
        parent::__construct(sprintf('Template for "%s" block type was not found.', $type));
    }
}