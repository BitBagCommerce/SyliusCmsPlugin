<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

class ContentConfiguration implements ContentConfigurationInterface
{
    protected ?int $id;

    protected ?string $type;

    protected array $configuration = [];

    protected ?BlockInterface $block = null;

    protected ?PageInterface $page = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function getBlock(): ?BlockInterface
    {
        return $this->block;
    }

    public function setBlock(?BlockInterface $block): void
    {
        $this->block = $block;
    }

    public function getPage(): ?PageInterface
    {
        return $this->page;
    }

    public function setPage(?PageInterface $page): void
    {
        $this->page = $page;
    }
}
