<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Template;

use Sylius\CmsPlugin\Entity\TemplateInterface;

interface IndexPageInterface
{
    public function deleteTemplate(TemplateInterface $template): void;
}
