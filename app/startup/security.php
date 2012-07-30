<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

$app->register(new SilexCMS\Security\Firewall('security', require __DIR__ . '/../config/users.php'));

$app->register(new SilexCMS\Page\StaticPage('login_success', '/login/success', 'security/login/success.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('login_failure', '/login/failure', 'security/login/failure.html.twig'));

$app->register(new SilexCMS\Page\StaticPage('logout_success', '/logout/success', 'security/logout/success.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('logout_failure', '/logout/failure', 'security/logout/failure.html.twig'));

$app->register(new SilexCMS\Page\StaticPage('login', '/login', 'security/login.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('logout', '/', 'index.html.twig'));

$app->post('/login', function (Application $app, Request $req) {
    $security = $app['security'];
    
    if ($security->bindSession()->getUserName() || $security->bindRequest($req)->getUsername()) {
        return $app->redirect($app['url_generator']->generate('administration_hub'));
    } else {
        return $app->redirect($app['url_generator']->generate('login_failure'));
    }
});

$app->post('/logout', function (Application $app, Request $req) {
    $security = $app['security'];

    if ($security->isLogged()) {
        $security->unbind();
        return $app->redirect($app['url_generator']->generate('index'));
    } else {
        return $app->redirect($app['url_generator']->generate('logout_failure'));
    }
});
