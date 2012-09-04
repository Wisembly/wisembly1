<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/config/config.php';
$app['debug'] = $config['debug'];

$locale = isset($locale) ? $locale : $config['default.locale'];

$dbOptions = require_once __DIR__ . '/config/database.php';
$dbOptions['charset'] = 'UTF8';
$dbOptions['dbname'] = $dbOptions['dbname'] . $locale;

$app = new SilexCMS\Application(array(
    'locale_fallback'       => $config['default.locale'],
    'locale'                => $locale,
    'twig.path'             => __DIR__ . '/../src/Application/Resources/views',
    'twig.options'          => array('debug' => $config['debug']),
    'db.options'            => $dbOptions,
));

$app['translator.domains'] = array(
    'messages' => array(
        'en' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.en.yml'),
        'fr' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.fr.yml'),
    ),
);

$app['twig']->addExtension(new SilexCMS\Twig\Extension\ForeignKeyExtension($app));

if ($app['debug']) {
    $app['twig']->addExtension(new Twig_Extensions_Extension_Debug());
    $app['twig']->enableDebug();
}

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options'   => require_once __DIR__ . '/config/mailer.php',
));

require_once __DIR__ . '/startup.php';

return $app;
