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

use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Section implements SectionInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $code;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
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

    public function getName(): ?string
    {
        return $this->getSectionTranslation()->getName();
    }

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

    protected function createTranslation(): TranslationInterface
    {
        return new SectionTranslation();
    }
}
