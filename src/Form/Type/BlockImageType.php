<?php

namespace BitBag\CmsPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

class BlockImageType extends ImageType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bitbag_cms_plugin_block_image';
    }
}