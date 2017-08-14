<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Exception;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class TemplateTypeNotFound extends \Exception
{
    public function __construct($type)
    {
        parent::__construct(sprintf('Template for "%s" block type was not found.', $type));
    }
}