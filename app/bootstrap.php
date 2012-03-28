<?php

require_once __DIR__ . '/autoload.php';

$app = new SilexCMS\Application(array(
    'locale_fallback' => 'en',
    
    'translation.class_path' => __DIR__ . '/../vendor/Symfony',
    'translator.messages' => array(),
    
    'twig.path' => __DIR__ . '/../src/Resources/views',
    
    'db.options' => require __DIR__ . '/config/database.php',
    'db.dbal.class_path' => __DIR__ . '/../vendor/Doctrine/dbal/lib',
    'db.common.class_path' => __DIR__ . '/../vendor/Doctrine/common/lib',
    
    'symfony_bridges.class_path' => __DIR__ . '/../vendor/Symfony',
));

$app['debug'] = true;
$app['twig']->enableDebug();

$app->register(new SilexCMS\Set\DataSet('foobars'));
$app->register(new SilexCMS\Form\Form('contact_form', __DIR__ . '/../src/Resources/forms/contact.yml'));
$app->register(new SilexCMS\Page\StaticPage('/', 'index.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('/', 'contact.html.twig'));

return $app;
