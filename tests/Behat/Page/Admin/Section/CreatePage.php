<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\Section;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsErrorTrait;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsErrorTrait;

    /**
     * {@inheritDoc}
     */
    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    /**
     * {@inheritDoc}
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }
}
