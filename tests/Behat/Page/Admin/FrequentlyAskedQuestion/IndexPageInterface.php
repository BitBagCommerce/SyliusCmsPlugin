<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface as BaseIndexPageInterface;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsEmptyListInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface IndexPageInterface extends BaseIndexPageInterface, ContainsEmptyListInterface
{
    /**
     * @param string $code
     */
    public function deleteFrequentlyAskedQuestion(string $code): void;
}
