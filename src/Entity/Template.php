<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

class Template implements TemplateInterface
{
    protected ?int $id;

    protected ?string $name;

    protected ?string $type;

    protected array $contentElements = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getContentElements(): array
    {
        return $this->contentElements;
    }

    public function setContentElements(array $contentElements): void
    {
        $this->contentElements = $contentElements;
    }
}
