<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Collection;

use Sylius\Behat\Page\Admin\Crud\IndexPage as BaseIndexPage;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsEmptyListTrait;

class IndexPage extends BaseIndexPage implements IndexPageInterface
{
    use ContainsEmptyListTrait;

    public function deleteCollection(string $code): void
    {
        $this->deleteResourceOnPage(['code' => $code]);
    }
}
