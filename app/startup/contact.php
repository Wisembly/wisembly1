<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SilexCMS\Form\Form;
use SilexCMS\Response\TransientResponse;

use Application\Form\Type\ContactType;

$app->register(new SilexCMS\Form\FormDescription('contact_form', new ContactType()));

$app->post('/contact/send', function (Application $app, Request $req) {
    $form = $app['contact_form'];
    $form->bindRequest($req);

    if ($form->isValid()) {
        $data = $form->getData();

        $message = \Swift_Message::newInstance()
                ->setSubject('[Contact Wisembly] De la grosse caillasse en perspective!')
                ->setFrom(array('no-reply@wisembly.com'))
                ->setTo(array('contact@wisembly.com'))
                ->setBody('User email: ' . $data['email'] . "\t\nMessage: " . $data['content']);

        $result = $app['mailer']->send($message);

        if ($result) {
            return $app->redirect($app['url_generator']->generate('contact', array('success' => true)));
        }

        return $app->redirect($app['url_generator']->generate('contact', array('success' => false)));
    }

    return $app->redirect($app['url_generator']->generate('contact', array('success' => false)));
})->bind('contact_send_mail');
