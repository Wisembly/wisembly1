<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SilexCMS\Form\Form;
use SilexCMS\Response\TransientResponse;

use Application\Form\Type\ContactType;
use Application\Entity\Contact;

$app->register(new SilexCMS\Form\FormDescription('contact_form', new ContactType()));
$app->post('/contact/send', function (Application $app, Request $req) {
    if ($app['security']->getUsername() === null) {
        return new TransientResponse($app['twig'], 'index.html.twig');
    }

    $contact = new Contact();

    $form = $app['contact_form'];
    $form->setData($contact);

    $form->bindRequest($req);

    if ($form->isValid() && !count($app['validator']->validate($contact))) {
        return 'ok';
    } else {
        return 'ko';
    }
});
