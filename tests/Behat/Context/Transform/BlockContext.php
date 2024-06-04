<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Webmozart\Assert\Assert;

final class BlockContext implements Context
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private string $locale = 'en_US'
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
