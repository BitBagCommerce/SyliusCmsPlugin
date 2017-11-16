<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    /**
     * {@inheritdoc}
     */
    public function deleteFrequentlyAskedQuestion(string $code): void
    {
        $this->deleteResourceOnPage(['code' => $code]);
    }
}
