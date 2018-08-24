<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Api\Sitemap\Provider;

use BitBag\SyliusCmsPlugin\Entity\Section;

class SitemapSectionControllerApiLocalesTest extends AbstractTestController
{
    /**
     * @before
     */
    public function setUpDatabase(): void
    {
        parent::setUpDatabase();

        $section = new Section();
        $section->setCurrentLocale('en_US');
        $section->setName('Test');
        $section->setCode('test');
        $section->setCurrentLocale('nl_NL');
        $section->setName('Test');
        $this->getEntityManager()->persist($section);

        $section = new Section();
        $section->setCurrentLocale('en_US');
        $section->setName('Mock');
        $section->setCode('mock');
        $section->setCurrentLocale('nl_NL');
        $section->setName('Mock');
        $this->getEntityManager()->persist($section);

        $this->getEntityManager()->flush();
    }

    public function testShowActionResponse(): void
    {
        $this->client->request('GET', '/sitemap/cms_sections.xml');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'show_sitemap_sections_locale');
    }
}
