<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Behaviour;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Behaviour\DocumentAccessor;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
trait ContainsError
{
    use DocumentAccessor;

    /**
     * @param string $message
     * @param bool $strict
     *
     * @return bool
     */
    public function containsErrorWithMessage($message, $strict = true): bool
    {
        $validationMessageElements = $this->getDocument()->findAll('css', '.sylius-validation-error');
        $result = false;

        /** @var NodeElement $validationMessageElement */
        foreach ($validationMessageElements as $validationMessageElement) {
            if (true === $strict && $message === $validationMessageElement->getText()) {
                return true;
            }

            if (false === $strict && strstr($validationMessageElement->getText(), $message)) {
                return true;
            }
        }

        return $result;
    }
}