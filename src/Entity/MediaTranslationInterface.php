<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface MediaTranslationInterface extends ResourceInterface, TranslationInterface
{
    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getAlt(): ?string;

    public function setAlt(?string $alt): void;

    public function getLink(): ?string;

    public function setLink(?string $link): void;
}
