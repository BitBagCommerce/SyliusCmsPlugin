<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
