<?php

/**
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;

class FrequentlyAskedQuestionTranslation extends AbstractTranslation implements FrequentlyAskedQuestionTranslationInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $question;

    /**
     * @var null|string
     */
    protected $answer;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * {@inheritdoc}
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * {@inheritdoc}
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
}
