<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\Page;

use Sylius\Behat\Page\SymfonyPage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'bitbag_sylius_cms_plugin_shop_page_index_by_section_code';
    }

    /**
     * {@inheritdoc}
     */
    public function hasSectionName(string $sectionName): bool
    {
        return $sectionName === $this->getElement('section')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function hasPagesNumber(int $pagesNumber): bool
    {
        $pagesNumberOnPage = count($this->getElement('pages')->findAll('css', '.bitbag-page'));

        return $pagesNumber === $pagesNumberOnPage;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'section' => '.bitbag-section-name',
            'pages' => '#bitbag-pages',
        ]);
    }
}
