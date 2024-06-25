<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ToggleableTrait;

class Block implements BlockInterface
{
    use ToggleableTrait;
    use CollectionableTrait;
    use ChannelsAwareTrait;
    use BlockContentAwareTrait;
    use LocaleAwareTrait;

    public function __construct()
    {
        $this->initializeCollectionsCollection();
        $this->initializeChannelsCollection();
        $this->initializeContentsCollection();
        $this->initializeLocalesCollection();
    }

    protected ?int $id;

    protected ?string $code = null;

    protected ?string $name;

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
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
