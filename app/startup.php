<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SilexCMS\Form\Form;

use Application\Form\Type\ContactType;
use Application\Entity\Contact;

$app->register(new SilexCMS\Set\DataSet('foobars'));
$app->register(new SilexCMS\Form\FormDescription('contact_form', new ContactType()));
$app->register(new SilexCMS\Page\StaticPage('/', 'index.html.twig'));
$app->register(new SilexCMS\Page\StaticPage('/contact', 'contact.html.twig'));

$app->post('/contact/send', function (Application $app, Request $req) {
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
