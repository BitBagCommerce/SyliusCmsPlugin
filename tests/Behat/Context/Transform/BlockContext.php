<?php

/*
 *  This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 *  You can find more information about us on https://bitbag.shop and write us
 *  an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Webmozart\Assert\Assert;

final class BlockContext implements Context
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var string */
    private $locale;

    public function __construct(BlockRepositoryInterface $blockRepository, string $locale = 'en_US')
    {
        $this->blockRepository = $blockRepository;
        $this->locale          = $locale;
    }

    /**
     * @Transform /^block(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" block(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :block
     */
    public function getBlockByCode($blockCode): BlockInterface
    {
        $block = $this->blockRepository->findEnabledByCode($blockCode, $this->locale);

        Assert::notNull(
            $block,
            sprintf('No blocks has been found with code "%s".', $blockCode)
        );

        return $block;
    }
}
