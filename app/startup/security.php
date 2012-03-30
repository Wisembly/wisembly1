<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

$app->register(new SilexCMS\Security\Firewall('security', array('demo' => 'demo')));
$app->register(new SilexCMS\Page\StaticPage('/login/status', 'login/status.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('/login/failure', 'login/failure.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('/login', 'login.html.twig'));

$app->post('/login', function (Application $app, Request $req) {
    $security = $app['security'];
    
    if ($security->bindSession()->getUserName() || $security->bindRequest($req)->getUsername()) {
        return $app->redirect('login/status');
    } else {
        return $app->redirect('login/failure');
    }
});
