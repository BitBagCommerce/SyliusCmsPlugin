<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class FrequentlyAskedQuestion implements FrequentlyAskedQuestionInterface
{
    use SectionableTrait;
    use ToggleableTrait,
        TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $code;

    /**
     * @var null|int
     */
    protected $position;

    public function __construct()
    {
        $this->initializeSectionsCollection();
        $this->initializeTranslationsCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestion(): ?string
    {
        return $this->getFrequentlyAskedQuestionTranslation()->getQuestion();
    }

    /**
     * {@inheritdoc}
     */
    public function setQuestion(?string $question): void
    {
        $this->getFrequentlyAskedQuestionTranslation()->setQuestion($question);
    }

    /**
     * {@inheritdoc}
     */
    public function getAnswer(): ?string
    {
        return $this->getFrequentlyAskedQuestionTranslation()->getAnswer();
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): TranslationInterface
    {
        return new FrequentlyAskedQuestionTranslation();
    }
}
