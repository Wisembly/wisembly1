<?php

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

// fetch global config
$config = require_once __DIR__ . '/config/config.php';

$locale = isset($locale) ? $locale : $config['default.locale'];

// fetch databases config
$dbOptions = require_once __DIR__ . '/config/database.php';
$localizedDbOptions = $dbOptions[$locale];
$localizedDbOptions['charset'] = 'UTF8';

// instanciate our SilexCMS
$app = new SilexCMS\Application(array(
    'locale_fallback'       => $config['default.locale'],
    'locale'                => $locale,
    'twig.path'             => __DIR__ . '/../src/Application/Resources/views',
    'twig.options'          => array('debug' => $config['debug']),
    'db.options'            => $localizedDbOptions,
));
$app['silexcms_locale'] = $locale;
$app['silexcms_full_db_options'] = $dbOptions;

// load locales
$app['translator.domains'] = array(
    'messages' => array(
        'en' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.en.yml'),
        'fr' => Yaml::parse(__DIR__ . '/../src/Application/Resources/translations/messages.fr.yml'),
    ),
);

// add usefull extensions / providers
$app['twig']->addExtension(new SilexCMS\Twig\Extension\ForeignKeyExtension($app));
$app['twig']->addExtension(new Application\Twig\Extension\StrReplaceExtension($app));
$app['twig']->addExtension(new Application\Twig\Extension\SwitchPathExtension($app));
$app['twig']->addExtension(new Application\Twig\Extension\AssetsExtension());

if ($config['debug']) {
    $app['debug'] = true;
    $app['twig']->addExtension(new Twig_Extensions_Extension_Debug());
    $app['twig']->enableDebug();
}

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options'   => require_once __DIR__ . '/config/mailer.php',
));

// set caching method if defined
if (isset($config['cache'])) {
    $app['cache.type'] = $config['cache'];
}

// now load php "controllers"
SilexCMS\Application::loadCore($app, array('security' => require_once __DIR__ . '/config/users.php'));

// ** cache strategy **
// check if page cache is fresh. Return cached response if so
$app->before(function(Request $request) use ($app) {
    // don't cache page if on admin page or if logged
    if (!preg_match('/^administration_/', $request->get('_route')) && is_null($app['security']->getUsername())) {
        return $app['silexcms.cache.manager']->check($request);
    }
});

// if page not cached, store it with the cache version to be rendered from cache next time
$app->finish(function(Request $request, $response) use ($app) {
    $app['silexcms.cache.manager']->persist($request, $response);
});

require_once __DIR__ . '/startup.php';

return $app;
