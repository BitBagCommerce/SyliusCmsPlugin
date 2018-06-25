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
