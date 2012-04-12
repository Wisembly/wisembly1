<?php

use Silex\Application;

// $app->register(new SilexCMS\Set\DataSet('foobars'));
$app->register(new SilexCMS\Page\StaticPage('/', 'index.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('/contact', 'contact.html.twig'));

require 'startup/security.php';
require 'startup/contact.php';
