<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType as BaseImageType;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ImageType extends BaseImageType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'bitbag_cms_plugin_image_block';
    }
}