<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../../../vendor/autoload.php';
require_once __DIR__ . '/AppKernel.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
