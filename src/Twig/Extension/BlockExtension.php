<?php

namespace BitBag\CmsPlugin\Twig\Extension;

use Symfony\Component\Templating\Helper\Helper;

class BlockExtension extends \Twig_Extension
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bitbag_render_block', [$this->helper, 'renderBlock']),
        );
    }
}