<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Template;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Sylius\CmsPlugin\Entity\TemplateInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    public function deleteTemplate(TemplateInterface $template): void
    {
        $this->deleteResourceOnPage(['name' => $template->getName()]);
    }
}
