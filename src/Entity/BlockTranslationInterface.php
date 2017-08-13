<?php

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface BlockTranslationInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @return ImageInterface
     */
    public function getImage();

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image);
}