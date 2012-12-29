<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SilexCMS\Form\Form;
use SilexCMS\Response\TransientResponse;

use Application\Form\Type\ContactType;

$app->register(new SilexCMS\Form\FormDescription('contact_form', new ContactType($app)));
$app->register(new SilexCMS\Form\FormDescription('contact_form_expanded', new ContactType($app, true)));

$app->post('/contact/send', function (Application $app, Request $req) {
    $form = $app['contact_form'];
    $form->bindRequest($req);

    if ($form->isValid()) {
        $data = $form->getData();

        $message = \Swift_Message::newInstance()
                ->setSubject('[Contact Wisembly] De la grosse caillasse en perspective!')
                ->setFrom(array('no-reply@wisembly.com'))
                ->setTo(array('contact@wisembly.com'))
                ->setBody('Email: ' . $data['email'] . "\t\nMessage: " . $data['content']);

        $result = $app['mailer']->send($message);

        if ($result) {
            return $app->redirect($app['url_generator']->generate('contact', array('success' => true)));
        }

        return $app->redirect($app['url_generator']->generate('contact', array('success' => false)));
    }

    return $app->redirect($app['url_generator']->generate('contact', array('success' => false)));
})->bind('contact_send_mail');

$app->post('/abonnement/send', function (Application $app, Request $req) {
    $form = $app['contact_form_expanded'];
    $form->bindRequest($req);

    if ($form->isValid()) {
        $data = $form->getData();

        $message = \Swift_Message::newInstance()
                ->setSubject('[Abonnement Wisembly] Récurrent en approche!')
                ->setFrom(array('no-reply@wisembly.com'))
                ->setTo(array('contact@wisembly.com'))
                ->setBody("Nom: " .$data['fullname'] . "\t\nEmail: " . $data['email'] . "\t\nSociété: ". $data['company'] . "\t\nType de réu: " . $data['type'] . "\t\nMessage: " . $data['content']);

        $result = $app['mailer']->send($message);

        if ($result) {
            return $app->redirect($app['url_generator']->generate('plans', array('success' => true)));
        }

        return $app->redirect($app['url_generator']->generate('plans', array('success' => false)));
    }

    return $app->redirect($app['url_generator']->generate('plans', array('success' => false)));
})->bind('abo_send_mail');
