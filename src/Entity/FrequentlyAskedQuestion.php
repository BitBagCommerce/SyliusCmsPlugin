<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class FrequentlyAskedQuestion implements FrequentlyAskedQuestionInterface
{
    use ChannelsAwareTrait;
    use ToggleableTrait,
        TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    /** @var int */
    protected $position;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->initializeChannelsCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getQuestion(): ?string
    {
        return $this->getFrequentlyAskedQuestionTranslation()->getQuestion();
    }

    public function setQuestion(?string $question): void
    {
        $this->getFrequentlyAskedQuestionTranslation()->setQuestion($question);
    }

    public function getAnswer(): ?string
    {
        return $this->getFrequentlyAskedQuestionTranslation()->getAnswer();
    }

    public function setAnswer(?string $answer): void
    {
        $this->getFrequentlyAskedQuestionTranslation()->setAnswer($answer);
    }

    /**
     * @return TranslationInterface|FrequentlyAskedQuestionTranslationInterface
     */
    protected function getFrequentlyAskedQuestionTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): TranslationInterface
    {
        return new FrequentlyAskedQuestionTranslation();
    }
}
