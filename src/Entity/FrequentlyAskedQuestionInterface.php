<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
