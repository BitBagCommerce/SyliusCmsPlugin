<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
