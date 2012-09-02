<?php

use Silex\Application;

// Datasets
$app->register(new SilexCMS\Set\DataSet('cases_featured', 'case_study', array('featured' => 1)));
$app->register(new SilexCMS\Set\DataSet('cases', 'case_study'));
$app->register(new SilexCMS\Set\DataSet('cases_categories', 'case_category'));
$app->register(new SilexCMS\Set\DataSet('clients', 'client'));
$app->register(new SilexCMS\Set\DataSet('clients_categories', 'client_category'));
$app->register(new SilexCMS\Set\DataSet('clients_featured', 'client', array('featured' => 1)));
$app->register(new SilexCMS\Set\DataSet('family', 'family'));
$app->register(new SilexCMS\Set\DataSet('filters', 'filter'));
$app->register(new SilexCMS\Set\DataSet('features', 'feature'));
$app->register(new SilexCMS\Set\DataSet('history', 'history'));
$app->register(new SilexCMS\Set\DataSet('team', 'team'));
$app->register(new SilexCMS\Set\DataSet('job_categories', 'job_category'));
$app->register(new SilexCMS\Set\DataSet('press', 'press'));
$app->register(new SilexCMS\Set\DataSet('press_featured', 'press', array('featured' => 1)));
$app->register(new SilexCMS\Set\DataSet('key_arguments', 'key_argument'));
$app->register(new SilexCMS\Set\DataSet('quotes', 'quote'));

// Pages
$app->register(new SilexCMS\Page\StaticPage('index', 	'/',            'index.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('cases', 	'/cases',       'cases.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('plans', 	'/plans',       'plans.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('contact', 	'/contact',     'contact.html.twig'     ));
$app->register(new SilexCMS\Page\StaticPage('about', 	'/about',     	'about.html.twig'     	));
$app->register(new SilexCMS\Page\StaticPage('client', 	'/clients',     'clients.html.twig'     ));

$app->register(new SilexCMS\Page\DynamicPage('feature', '/features/{slug}', 'features.html.twig', 'filter'));
$app->register(new SilexCMS\Page\DynamicPage('case_category', '/cases/{slug}', 'cases_categories.html.twig', 'case_category'));

foreach (glob(__DIR__ . '/startup/*.php') as $file) {
    require_once $file;
}
