<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ImageType extends ImageType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bitbag_cms_plugin_block_image';
    }
}