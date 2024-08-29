<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    public function deletePage(string $code): void
    {
        $this->deleteResourceOnPage(['code' => $code]);
    }
}
