<?php

namespace BitBag\CmsPlugin\EventListener;

use Sylius\Component\Core\Uploader\ImageUploaderInterface;

class BlockImageUploadListener
{
    /**
     * @var ImageUploaderInterface
     */
    private $uploader;

    /**
     * @param ImageUploaderInterface $uploader
     */
    public function __construct(ImageUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }
}