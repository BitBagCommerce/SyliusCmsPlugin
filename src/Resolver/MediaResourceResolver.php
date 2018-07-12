<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use Psr\Log\LoggerInterface;

final class MediaResourceResolver implements MediaResourceResolverInterface
{
    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(MediaRepositoryInterface $mediaRepository, LoggerInterface $logger)
    {
        $this->mediaRepository = $mediaRepository;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?MediaInterface
    {
        $media = $this->mediaRepository->findOneEnabledByCode($code);

        if (false === $media instanceof MediaInterface) {
            $this->logger->warning(sprintf(
                'Media with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $media;
    }
}
