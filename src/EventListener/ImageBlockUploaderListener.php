<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\EventListener;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\BlockTranslationInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ImageBlockUploaderListener
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

    /**
     * @param ResourceControllerEvent $event
     */
    public function uploadImage(ResourceControllerEvent $event)
    {
        $block = $event->getSubject();

        if (!$block instanceof BlockInterface) {
            return;
        }

        if (!$block->getType() === BlockInterface::IMAGE_BLOCK_TYPE) {
            return;
        }

        /** @var BlockTranslationInterface $translation */
        foreach ($block->getTranslations() as $translation) {
            if ($translation->getImage() !== null) {
                $this->uploadImageBlock($translation->getImage());
            }
        }
    }

    /**
     * @param ImageInterface $image
     */
    private function uploadImageBlock(ImageInterface $image)
    {
        if ($image->hasFile()) {
            $this->uploader->upload($image);
        }
    }
}