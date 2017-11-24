<?php

/**
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorTrait;

class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    /**
     * {@inheritDoc}
     */
    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }
    /**
     * {@inheritdoc}
     */
    public function setPosition(int $position): void
    {
        $this->getDocument()->fillField('Position', $position);
    }

    /**
     * {@inheritdoc}
     */
    public function fillQuestion(string $question): void
    {
        $this->getDocument()->fillField('Question', $question);
    }

    /**
     * {@inheritdoc}
     */
    public function fillAnswer(string $answer): void
    {
        $this->getDocument()->fillField('Answer', $answer);
    }
}
