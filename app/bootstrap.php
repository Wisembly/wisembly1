<?php

require_once __DIR__ . '/autoload.php';

$database = require __DIR__ . '/config/database.php';

$app = new Silex\Application();

$app->register(new \Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../src/Resources/views'));
$app->register(new \Silex\Provider\DoctrineServiceProvider(), array('db.options' => $database, 'db.dbal.class_path' => __DIR__ . '/../vendor/Doctrine/dbal/lib', 'db.common.class_path' => __DIR__ . '/../vendor/Doctrine/common/lib'));

$app->register(new SilexCMS\Set\DataSet('foobars'));
$app->register(new SilexCMS\Page\StaticPage('/', 'index.html.twig'));

$app['debug'] = true;
$app['twig']->addExtension(new Twig_Extension_Debug());
$app['twig']->enableDebug();

return $app;
