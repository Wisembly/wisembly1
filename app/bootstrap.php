<?php

require_once __DIR__ . '/autoload.php';

$app = new SilexCMS\Application(array(
    'twig.path' => __DIR__ . '/../src/Resources/views',
    
    'db.options' => require __DIR__ . '/config/database.php',
    'db.dbal.class_path' => __DIR__ . '/../vendor/Doctrine/dbal/lib',
    'db.common.class_path' => __DIR__ . '/../vendor/Doctrine/common/lib',
));

$app->register(new SilexCMS\Set\DataSet('foobars'));
$app->register(new SilexCMS\Page\StaticPage('/', 'index.html.twig'));

return $app;
