<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

    /** @var int */
    protected $id;

    /** @var string */
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
        /** @var SectionTranslationInterface $sectionTranslationInterface */
        $sectionTranslationInterface = $this->getSectionTranslation();
        return $sectionTranslationInterface->getName();
    }

    public function setName(?string $name): void
    {
        /** @var SectionTranslationInterface $sectionTranslationInterface */
        $sectionTranslationInterface = $this->getSectionTranslation();
        $sectionTranslationInterface->setName($name);
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
