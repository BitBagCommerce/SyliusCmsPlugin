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

use BitBag\SyliusCmsPlugin\Entity\Page;

class SitemapPageControllerApiLocalesTest extends AbstractTestController
{
    /**
     * @before
     *
     * {@inheritdoc}
     */
    public function setUpDatabase(): void
    {
        parent::setUpDatabase();

        $product = new Page();
        $product->setCurrentLocale('en_US');
        $product->setName('Test');
        $product->setCode('test-code');
        $product->setSlug('test');
        $product->setCurrentLocale('nl_NL');
        $product->setName('Test');
        $product->setCode('test-code');
        $product->setSlug('test-nl');
        $this->getEntityManager()->persist($product);

        $product = new Page();
        $product->setCurrentLocale('en_US');
        $product->setName('Mock');
        $product->setCode('mock-code');
        $product->setSlug('mock');
        $product->setCurrentLocale('nl_NL');
        $product->setName('Mock');
        $product->setCode('mock-code');
        $product->setSlug('mock-nl');
        $this->getEntityManager()->persist($product);

        $product = new Page();
        $product->setCurrentLocale('en_US');
        $product->setName('Test 2');
        $product->setCode('test-code-3');
        $product->setSlug('test 2');
        $product->setCurrentLocale('nl_NL');
        $product->setName('Test 2');
        $product->setCode('test-code-3');
        $product->setSlug('test 2');
        $product->setEnabled(false);
        $this->getEntityManager()->persist($product);

        $product = new Page();
        $product->setCurrentLocale('en_US');
        $product->setName('Test 3');
        $product->setCode('test-code-4');
        $product->setSlug('test 3');
        $product->setCurrentLocale('nl_NL');
        $product->setName('Test 3');
        $product->setCode('test-code-4');
        $product->setSlug('test 3');
        $product->setEnabled(false);
        $this->getEntityManager()->persist($product);

        $this->getEntityManager()->flush();
    }

    public function testShowActionResponse(): void
    {
        $this->client->request('GET', '/sitemap/cms_pages.xml');
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'show_sitemap_pages_locale');
    }
}
