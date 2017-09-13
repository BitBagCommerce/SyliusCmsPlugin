<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\CmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\CreatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\UpdatePageInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageContext implements Context
{
    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @var UpdatePageInterface
     */
    private $updatePage;

    /**
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     */
    public function __construct(
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage
    )
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }

    /**
     * @Transform /^fields "([^"]+)" and "([^"]+)"$/
     * @Transform /^fields "([^"]+)", "([^"]+)" and "([^"]+)"$/
     */
    public function getProductsByNames(...$fields)
    {
        return array_map(function ($field) {

        }, $fields);
    }
}