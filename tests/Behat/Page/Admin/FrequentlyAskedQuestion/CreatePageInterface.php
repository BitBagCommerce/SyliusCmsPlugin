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

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsErrorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $label
     * @param string $value
     */
    public function fillField(string $label, string $value): void;

    /**
     * @param string $code
     */
    public function fillCode(string $code): void;

    /**
     * @param int $position
     */
    public function setPosition(int $position): void;

    /**
     * @param string $question
     */
    public function fillQuestion(string $question): void;

    /**
     * @param string $answer
     */
    public function fillAnswer(string $answer): void;
}