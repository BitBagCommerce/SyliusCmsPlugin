<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\Page;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    public function getRouteName(): string
    {
        return 'bitbag_sylius_cms_plugin_shop_page_index_by_section_code';
    }

    public function hasSectionName(string $sectionName): bool
    {
        return $sectionName === $this->getElement('section')->getText();
    }

    public function hasPagesNumber(int $pagesNumber): bool
    {
        $pagesNumberOnPage = count($this->getElement('pages')->findAll('css', '.bitbag-page'));

        return $pagesNumber === $pagesNumberOnPage;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'section' => '.bitbag-section-name',
            'pages' => '#bitbag-pages',
        ]);
    }
}
