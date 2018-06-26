<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ImageType as BaseImageType;

final class PageImageType extends BaseImageType
{
    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_page_image';
    }
}
