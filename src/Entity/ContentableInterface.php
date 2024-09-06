<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

interface ContentableInterface
{
    public function getContent(): ?string;
}
