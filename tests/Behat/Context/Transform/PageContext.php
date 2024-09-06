<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Webmozart\Assert\Assert;

final class PageContext implements Context
{
    public function __construct(
        private PageRepositoryInterface $pageRepository,
        private string $locale = 'en_US',
    ) {
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
            sprintf('No pages has been found with code "%s".', $pageCode),
        );

        return $page;
    }
}
