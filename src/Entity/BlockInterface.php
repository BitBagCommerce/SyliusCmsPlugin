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
use Sylius\Component\Resource\Model\TranslatableInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface BlockInterface extends ResourceInterface, TranslatableInterface
{
    const TEXT_BLOCK_TYPE = 'text';
    const IMAGE_BLOCK_TYPE = 'image';
    const HTML_BLOCK_TYPE = 'html';

    /**
     * @return string
     */
    public function getType(): ?string;

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void;

    /**
     * @return null|string
     */
    public function getCode(): ?string;

    /**
     * @param null|string $code
     */
    public function setCode(?string $code): void;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void;

    /**
     * @return null|string
     */
    public function getContent(): ?string;

    /**
     * @param string $content
     */
    public function setContent(?string $content): void;

    /**
     * @return ImageInterface
     */
    public function getImage(): ?ImageInterface;

    /**
     * @param ImageInterface $image
     */
    public function setImage(?ImageInterface $image): void;

    /**
     * @return null|string
     */
    public function getLink(): ?string;

    /**
     * @param null|string $link
     */
    public function setLink(?string $link): void;
}
