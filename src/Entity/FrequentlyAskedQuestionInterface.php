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
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface FrequentlyAskedQuestionInterface extends ResourceInterface, TranslatableInterface, ToggleableInterface
{
    /**
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void;

    /**
     * @return int|null
     */
    public function getPosition(): ?int;

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void;

    /**
     * @return string|null
     */
    public function getQuestion(): ?string;

    /**
     * @param string|null $question
     */
    public function setQuestion(?string $question): void;

    /**
     * @return string|null
     */
    public function getAnswer(): ?string;

    /**
     * @param string|null $answer
     */
    public function setAnswer(?string $answer): void;
}
