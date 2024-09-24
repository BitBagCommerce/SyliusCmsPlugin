<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface PageInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    CollectibleInterface,
    TimestampableInterface,
    ChannelsAwareInterface,
    SlugAwareInterface,
    ContentElementsAwareInterface,
    TeaserInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getMetaKeywords(): ?string;

    public function setMetaKeywords(?string $metaKeywords): void;

    public function getMetaDescription(): ?string;

    public function setMetaDescription(?string $metaDescription): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;
}
