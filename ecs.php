<?php

declare(strict_types=1);

use BitBag\SyliusCmsPlugin\Fixer\AboveTwoArgumentsMultilineFixer;
use BitBag\SyliusCmsPlugin\Fixer\FinalClassInEntitiesOrRepositoriesFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('vendor/sylius-labs/coding-standard/ecs.php');
    $services = $containerConfigurator->services();
    $services->set(AboveTwoArgumentsMultilineFixer::class);
    $services->set(FinalClassInEntitiesOrRepositoriesFixer::class);
    $services->set(YodaStyleFixer::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
};
