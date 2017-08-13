<?php

namespace BitBag\CmsPlugin\Templating\Helper;

use BitBag\CmsPlugin\Exception\BlockNotFoundException;
use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;

interface BlockHelperInterface
{
    /**
     * @param string $code
     * @return string|TemplateTypeNotFound|BlockNotFoundException
     */
    public function renderBlock($code);
}