<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
interface BlockTranslationInterface extends ResourceInterface, TranslationInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void;

    /**
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * @param string $content
     */
    public function setContent(?string $content): void;

    /**
     * @return ImageInterface|null
     */
    public function getImage(): ?ImageInterface;

    /**
     * @param ImageInterface $image
     */
    public function setImage(?ImageInterface $image): void;

    /**
     * @return string|null
     */
    public function getLink(): ?string;

    /**
     * @param string|null $link
     */
    public function setLink(?string $link): void;
}