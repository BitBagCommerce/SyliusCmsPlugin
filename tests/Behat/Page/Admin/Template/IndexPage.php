<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Template;

use BitBag\SyliusCmsPlugin\Entity\TemplateInterface;
use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    public function deleteTemplate(TemplateInterface $template): void
    {
        $this->deleteResourceOnPage(['name' => $template->getName()]);
    }
}
