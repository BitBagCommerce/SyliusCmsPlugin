<?php

declare(strict_types=1);

namespace Acme\SyliusExamplePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AcmeSyliusExamplePlugin extends Bundle
{
    use SyliusPluginTrait;
}
