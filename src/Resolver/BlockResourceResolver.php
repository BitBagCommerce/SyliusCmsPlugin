<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Psr\Log\LoggerInterface;

final class BlockResourceResolver implements BlockResourceResolverInterface
{
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param BlockRepositoryInterface $blockRepository
     * @param LoggerInterface $logger
     */
    public function __construct(BlockRepositoryInterface $blockRepository, LoggerInterface $logger)
    {
        $this->blockRepository = $blockRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function findOrLog(string $code): ?BlockInterface
    {
        $block = $this->blockRepository->findOneEnabledByCode($code);

        if (false === $block instanceof BlockInterface) {
            $this->logger->warning(sprintf(
                'Block with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $block;
    }
}
