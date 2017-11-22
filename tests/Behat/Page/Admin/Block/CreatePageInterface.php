<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $label
     * @param string $value
     */
    public function fillField(string $label, string $value);

    /**
     * @param string $code
     */
    public function fillCode(string $code): void;

    /**
     * @param string $image
     */
    public function uploadImage(string $image): void;

    /**
     * @param string $name
     */
    public function fillName(string $name): void;

    /**
     * @param string $link
     */
    public function fillLink(string $link): void;

    /**
     * @param string $content
     */
    public function fillContent(string $content): void;

    /**
     * @param array $sectionsNames
     */
    public function associateSections(array $sectionsNames): void;

    public function disable(): void;
}
