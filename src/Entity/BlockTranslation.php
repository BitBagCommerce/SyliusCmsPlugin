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
use Sylius\Component\Resource\Model\AbstractTranslation;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
class BlockTranslation extends AbstractTranslation implements BlockTranslationInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var ImageInterface
     */
    protected $image;

    /**
     * @var string
     */
    protected $link;

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage(?ImageInterface $image): void
    {
        $image->setOwner($this);

        $this->image = $image;
    }

    /**
     * {@inheritdoc}
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * {@inheritdoc}
     */
    public function setLink(?string $link): void
    {
        $this->link = $link;
    }
}