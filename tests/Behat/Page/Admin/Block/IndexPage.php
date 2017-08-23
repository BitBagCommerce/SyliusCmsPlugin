<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\Clickable;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use Clickable;

    /**
     * {@inheritdoc}
     */
    public function containsBlocksWithType($number, $type)
    {
    }

    /**
     * @param string $code
     */
    public function removeBlock($code)
    {
        // TODO: Implement removeBlock() method.
    }

    /**
     * @param array ...$blockTypes
     *
     * @throws
     */
    public function shouldContainBlockTypes(...$blockTypes)
    {
        // TODO: Implement shouldContainBlockTypes() method.
    }
}