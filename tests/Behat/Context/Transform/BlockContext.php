<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Webmozart\Assert\Assert;

final class BlockContext implements Context
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private string $locale = 'en_US',
    ) {
    }

    /**
     * @Transform /^block(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" block(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :block
     */
    public function getBlockByCode(string $blockCode): BlockInterface
    {
        $block = $this->blockRepository->findEnabledByCode($blockCode, $this->locale);

        Assert::notNull(
            $block,
            sprintf('No blocks has been found with code "%s".', $blockCode),
        );

        return $block;
    }
}
