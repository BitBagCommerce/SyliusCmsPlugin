<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;
use Webmozart\Assert\Assert;

class BlockTranslation extends AbstractTranslation implements BlockTranslationInterface
{
    /** @var int */
    protected $id;

    /** @var string|null */
    protected $name;

    /** @var string|null */
    protected $content;

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
        Assert::notNull($content, sprintf('Content of block translation identified by id: "%s", passed to setter, is null', $this->getId()));
        $this->content = $content;
    }

    public function getId(): ?int
    {
        return $this->id;
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
