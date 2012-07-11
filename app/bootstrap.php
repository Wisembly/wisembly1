<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new SilexCMS\Application(array(
    'locale_fallback' => 'en',
    
    'translator.messages' => array(),
    'translator.domains' => array(),
    
    'twig.path' => __DIR__ . '/../src/Application/Resources/views',
    
    'db.options' => require __DIR__ . '/config/database.php',
));

$app['debug'] = true;
$app['twig']->enableDebug();

require __DIR__ . '/startup.php';

return $app;
