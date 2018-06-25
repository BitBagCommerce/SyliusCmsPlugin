<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\EventListener;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Webmozart\Assert\Assert;

final class BlockImageUploadListener
{
    /** @var ImageUploaderInterface */
    private $uploader;

    public function __construct(ImageUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadImage(ResourceControllerEvent $event): void
    {
        $block = $event->getSubject();

        Assert::isInstanceOf($block, BlockInterface::class);

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
