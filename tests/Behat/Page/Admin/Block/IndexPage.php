<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    /**
     * {@inheritdoc}
     */
    public function getBlocksWithTypeCount(string $type): int
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');

        return count($tableAccessor->getRowsWithFields($table, ['type' => $type]));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteBlock(string $code): void
    {
        $this->deleteResourceOnPage(['code' => $code]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockTypes(): array
    {
        $blockTypes = $this->getDocument()->findAll('css', '#create-block-dropdown a');
        $result = [];

        /** @var NodeElement $blockType */
        foreach ($blockTypes as $blockType) {
            $result[] = $blockType->getText();
        }

        return $result;
    }
}
