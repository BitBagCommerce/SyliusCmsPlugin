<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface FrequentlyAskedQuestionTranslationInterface extends TranslationInterface, ResourceInterface
{
    /**
     * @return null|string
     */
    public function getQuestion(): ?string;

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void;

    /**
     * @return null|string
     */
    public function getAnswer(): ?string;

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void;
}
