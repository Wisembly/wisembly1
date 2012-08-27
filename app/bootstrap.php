<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dbOptions = require __DIR__ . '/config/database.php';
$dbOptions['charset'] = 'UTF8';

$app = new SilexCMS\Application(array(
    'locale_fallback' => 'en',

    'translator.messages' => array(),
    'translator.domains' => array(),

    'twig.path' => __DIR__ . '/../src/Application/Resources/views',

    'db.options' => $dbOptions,
));

$app['debug'] = true;
$app['twig']->enableDebug();

require __DIR__ . '/startup.php';

return $app;
