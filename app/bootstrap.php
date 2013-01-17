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
    'twig.options'          => array(
        'debug' => $config['debug'],
        'cache' => __DIR__ . '/cache',
    ),
    'db.options'            => $localizedDbOptions,
));
$app['silexcms_locale'] = $locale;
$app['silexcms_full_db_options'] = $dbOptions;

// phone numbers
$app['phone.numbers'] = array(
    'en'    =>  '+442036081474',
    'fr'    =>  '0982369008',
    'de'    =>  '+498007234918',
    'es'    =>  '+34931807007',
    'ch'    =>  '+41435083520',
    'be'    =>  '+3225881720',
);

$app['phone_number'] = $app['phone.numbers'][isset($phone_number) ? $phone_number : 'fr'];

// load locales
$locale_list = array_keys($dbOptions);
$messages = array();
foreach ($locale_list as $locale) {
  $messages[$locale] = Yaml::parse(__DIR__ . "/../src/Application/Resources/translations/messages.{$locale}.yml");
}

$app['translator.domains'] = array(
  'messages' => $messages
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
    if (!preg_match('/^administration_/', $request->get('_route')) && is_null($app['silexcms.security']->getUsername())) {
        return $app['silexcms.cache.manager']->check($request);
    }
});

// if page not cached, store it with the cache version to be rendered from cache next time
$app->finish(function(Request $request, $response) use ($app) {
    $app['silexcms.cache.manager']->persist($request, $response);
});

require_once __DIR__ . '/startup.php';

return $app;
