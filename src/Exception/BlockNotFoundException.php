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
class BlockNotFoundException extends \Exception
{
    public function __construct($code)
    {
        parent::__construct(sprintf("Block for %s code was not found.", $code));
    }
}