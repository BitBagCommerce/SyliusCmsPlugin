<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    public function getBlocksWithTypeCount(string $type): int
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');

        return count($tableAccessor->getRowsWithFields($table, ['type' => $type]));
    }

    public function deleteBlock(string $code): void
    {
        $this->deleteResourceOnPage(['code' => $code]);
    }
}
