<?php

use Silex\Application;

// Datasets
$app->register(new SilexCMS\Set\DataSet('cases_featured', 'cases'));
$app->register(new SilexCMS\Set\DataSet('cases', 'cases'));
$app->register(new SilexCMS\Set\DataSet('clients', 'clients'));

// Pages
$app->register(new SilexCMS\Page\StaticPage('index', 	'/',            'index.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('features', '/features',    'features.html.twig'    ));
$app->register(new SilexCMS\Page\StaticPage('cases', 	'/cases',       'cases.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('plans', 	'/plans',       'plans.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('contact', 	'/contact',     'contact.html.twig'     ));

foreach (glob(__DIR__ . '/startup/*.php') as $file)
    require $file;
