<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$dbOptions = require_once __DIR__ . '/config/database.php';
$dbOptions['charset'] = 'UTF8';

$app = new SilexCMS\Application(array(
    'locale_fallback'       => 'en',
    'locale'                => isset($locale) ? $locale : 'en',
    'twig.path'             => __DIR__ . '/../src/Application/Resources/views',
    'twig.options'          => array('debug' => true),

    'db.options'            => $dbOptions,
));

$app['translator.domains'] = array(
    'messages' => array(
        'en' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.en.yml'),
        'fr' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.fr.yml'),
    ),
);

$app['debug'] = true;
$app['twig']->addExtension(new Twig_Extensions_Extension_Debug());
$app['twig']->enableDebug();

require_once __DIR__ . '/startup.php';

return $app;
