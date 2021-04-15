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

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface FrequentlyAskedQuestionInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    ChannelsAwareInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getPosition(): ?int;

    public function setPosition(?int $position): void;

    public function getQuestion(): ?string;

    public function setQuestion(?string $question): void;

    public function getAnswer(): ?string;

    public function setAnswer(?string $answer): void;
}
