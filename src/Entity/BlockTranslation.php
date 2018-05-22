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

use Sylius\Component\Resource\Model\AbstractTranslation;

class BlockTranslation extends AbstractTranslation implements BlockTranslationInterface
{
    /** @var int */
    protected $id;

    /** @var string|null */
    protected $name;

    /** @var string|null */
    protected $content;

    /** @var BlockImageInterface|null */
    protected $image;

    /** @var string|null */
    protected $link;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?BlockImageInterface
    {
        return $this->image;
    }

    public function setImage(?BlockImageInterface $image): void
    {
        $image->setOwner($this);

        $this->image = $image;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }
}
