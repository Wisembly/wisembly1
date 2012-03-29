<?php

require_once __DIR__ . '/autoload.php';

$app = new SilexCMS\Application(array(
    'locale_fallback' => 'en',
    
    'validator.class_path' => __DIR__ . '/../vendor/Symfony',
    
    'translation.class_path' => __DIR__ . '/../vendor/Symfony',
    'translator.messages' => array(),
    
    'twig.path' => __DIR__ . '/../src/Application/Resources/views',
    
    'db.options' => require __DIR__ . '/config/database.php',
    'db.dbal.class_path' => __DIR__ . '/../vendor/Doctrine/dbal/lib',
    'db.common.class_path' => __DIR__ . '/../vendor/Doctrine/common/lib',
    
    'symfony_bridges.class_path' => __DIR__ . '/../vendor/Symfony',
));

$app['debug'] = true;
$app['twig']->enableDebug();

require __DIR__ . '/startup.php';

return $app;
