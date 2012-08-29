<?php

use Silex\Application;

// Datasets
$app->register(new SilexCMS\Set\DataSet('cases_featured', 'cases', array('featured' => 1)));
$app->register(new SilexCMS\Set\DataSet('cases', 'cases'));
$app->register(new SilexCMS\Set\DataSet('cases_categories', 'cases_categories'));
$app->register(new SilexCMS\Set\DataSet('clients', 'clients'));
$app->register(new SilexCMS\Set\DataSet('clients_categories', 'clients_categories'));
$app->register(new SilexCMS\Set\DataSet('clients_featured', 'clients', array('featured' => 1)));
$app->register(new SilexCMS\Set\DataSet('family', 'family'));
$app->register(new SilexCMS\Set\DataSet('filters', 'filters'));
$app->register(new SilexCMS\Set\DataSet('features', 'features'));
$app->register(new SilexCMS\Set\DataSet('history', 'history'));
$app->register(new SilexCMS\Set\DataSet('team', 'team'));
$app->register(new SilexCMS\Set\DataSet('job_categories', 'job_categories'));
$app->register(new SilexCMS\Set\DataSet('press', 'press'));
$app->register(new SilexCMS\Set\DataSet('key_arguments', 'key_arguments'));
$app->register(new SilexCMS\Set\DataSet('quotes', 'quotes'));

// Pages
$app->register(new SilexCMS\Page\StaticPage('index', 	'/',            'index.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('cases', 	'/cases',       'cases.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('plans', 	'/plans',       'plans.html.twig'       ));
$app->register(new SilexCMS\Page\StaticPage('contact', 	'/contact',     'contact.html.twig'     ));
$app->register(new SilexCMS\Page\StaticPage('about', 	'/about',     	'about.html.twig'     	));
$app->register(new SilexCMS\Page\StaticPage('client', 	'/clients',     	'clients.html.twig'     ));

$app->register(new SilexCMS\Page\DynamicPage('features', '/features/{slug}', 'features.html.twig', 'filters'  ));
$app->register(new SilexCMS\Page\DynamicPage('cases_categories', '/cases/{slug}', 'cases_categories.html.twig', 'cases_categories'  ));

foreach (glob(__DIR__ . '/startup/*.php') as $file) {
    require_once $file;
}
