<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

// fetch global config
$config = require_once __DIR__ . '/config/config.php';
$app['debug'] = $config['debug'];

$locale = isset($locale) ? $locale : $config['default.locale'];

// fetch databases config
$dbOptions = require_once __DIR__ . '/config/database.php';
$dbOptions = $dbOptions[$locale];
$dbOptions['charset'] = 'UTF8';

// instanciate our SilexCMS
$app = new SilexCMS\Application(array(
    'locale_fallback'       => $config['default.locale'],
    'locale'                => $locale,
    'twig.path'             => __DIR__ . '/../src/Application/Resources/views',
    'twig.options'          => array('debug' => $config['debug']),
    'db.options'            => $dbOptions,
));

// load locales
$app['translator.domains'] = array(
    'messages' => array(
        'en' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.en.yml'),
        'fr' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.fr.yml'),
    ),
);

// add usefull extensions / providers
$app['twig']->addExtension(new SilexCMS\Twig\Extension\ForeignKeyExtension($app));
if (true === $app['debug']) {
    $app['twig']->addExtension(new Twig_Extensions_Extension_Debug());
    $app['twig']->enableDebug();
}

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options'   => require_once __DIR__ . '/config/mailer.php',
));

$app->register(new SilexCMS\Security\Firewall('security', require __DIR__ . '/config/users.php'));

// now load php "controllers"
SilexCMS\Application::loadActions($app);
require_once __DIR__ . '/startup.php';

return $app;
