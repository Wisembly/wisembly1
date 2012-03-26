<?php

require_once __DIR__ . '/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new \Symfony\Component\ClassLoader\UniversalClassLoader();

$loader->registerPrefix('Pimple', __DIR__ . '/../vendor/Pimple/lib');
$loader->registerPrefix('Twig_', __DIR__ . '/../vendor/Twig/lib');

$loader->registerNamespace('Symfony', __DIR__ . '/../vendor');

$loader->registerNamespace('Silex', __DIR__ . '/../vendor/Silex/src');
$loader->registerNamespace('SilexCMS', __DIR__ . '/../vendor/SilexCMS/src');

$loader->register();
