<?php

namespace Tests\BitBag\SyliusCmsPlugin\Api\Sitemap\Provider;

use BitBag\SyliusCmsPlugin\Entity\Page;

class SitemapPageControllerApiTest extends AbstractTestController
{

    /**
     * @before
     */
    public function setUpDatabase()
    {
        parent::setUpDatabase();

        $page = new Page();
        $page->setCurrentLocale('en_US');
        $page->setName('Test');
        $page->setCode('test-code');
        $page->setSlug('test');
        $this->getEntityManager()->persist($page);
        $page = new Page();
        $page->setCurrentLocale('en_US');
        $page->setName('Mock');
        $page->setCode('mock-code');
        $page->setSlug('mock');
        $this->getEntityManager()->persist($page);
        $page = new Page();
        $page->setCurrentLocale('en_US');
        $page->setName('Test 2');
        $page->setCode('test-code-3');
        $page->setSlug('test 2');
        $page->setEnabled(false);
        $this->getEntityManager()->persist($page);
        $this->getEntityManager()->flush();
    }

    public function testShowActionResponse()
    {
        $this->client->request('GET', '/sitemap/cms_pages.xml');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'show_sitemap_pages');
    }

}
