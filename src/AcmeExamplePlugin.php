<?php

namespace Acme\ExamplePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AcmeExamplePlugin extends Bundle
{
    use SyliusPluginTrait;
}
