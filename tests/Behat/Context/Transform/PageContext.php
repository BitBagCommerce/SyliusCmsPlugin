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
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Webmozart\Assert\Assert;

final class PageContext implements Context
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var string */
    private $locale;

    public function __construct(PageRepositoryInterface $pageRepository, string $locale = 'en_US')
    {
        $this->pageRepository = $pageRepository;
        $this->locale = $locale;
    }

    /**
     * @Transform /^page(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" page(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :page
     */
    public function getPageByCode(string $pageCode): PageInterface
    {
        $page = $this->pageRepository->findOneEnabledByCode($pageCode, $this->locale);

        Assert::notNull(
            $page,
            sprintf('No pages has been found with code "%s".', $pageCode)
        );

        return $page;
    }
}
