<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Section implements SectionInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /**
     * @var null|int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $code;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
    }

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
    public function getName(): ?string
    {
        return $this->getSectionTranslation()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->getSectionTranslation()->setName($name);
    }

    /**
     * @return TranslationInterface|SectionTranslationInterface
     */
    protected function getSectionTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): TranslationInterface
    {
        return new SectionTranslation();
    }
}
