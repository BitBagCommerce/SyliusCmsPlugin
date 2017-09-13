<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\EventListener;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Entity\BlockTranslationInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class ImageBlockUploadListener
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
    public function uploadImage(ResourceControllerEvent $event): void
    {
        $block = $event->getSubject();

        if (false === $block instanceof BlockInterface) {

            return;
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE !== $block->getType()) {

            return;
        }

        /** @var BlockTranslationInterface $translation */
        foreach ($block->getTranslations() as $translation) {
            $image = $translation->getImage();

            if (null !== $image && true === $image->hasFile()) {
                $this->uploader->upload($image);
            }
        }
    }
}