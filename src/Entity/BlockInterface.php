<?php

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface BlockInterface extends ResourceInterface, TranslatableInterface
{
    const  TEXT_BLOCK_TYPE = 'text';

    const  IMAGE_BLOCK_TYPE = 'image';

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     */
    public function setContent($content);

}