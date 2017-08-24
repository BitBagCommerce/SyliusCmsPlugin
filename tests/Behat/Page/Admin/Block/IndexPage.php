<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBlocksWithTypeCount($type)
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');

        return count($tableAccessor->getRowsWithFields($table, ['type' => $type]));
    }

    /**
     * {@inheritdoc}
     */
    public function removeBlock($code)
    {
        $this->deleteResourceOnPage(['code' => $code]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockTypes()
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