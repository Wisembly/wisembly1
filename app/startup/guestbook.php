<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use SilexCMS\Form\Form;
use SilexCMS\Response\TransientResponse;

use Guestbook\Form\Type\EntryType;
use Guestbook\Entity\Entry;
use Guestbook\Entity\EntryRepository;

$app->register(new SilexCMS\Set\DataSet('entries', 'entries'));
$app->register(new SilexCMS\Form\FormDescription('entry_form', new EntryType()));

$app->register(new SilexCMS\Page\StaticPage('index', '/', 'index.html.twig'));
$app->post('/add', function (Application $app, Request $req) {

    if ($app['security']->getUsername() !== null) {

        $entry = new Entry();

        $form = $app['entry_form'];
        $form->setData($entry);
        $form->bindRequest($req);

        if ($form->isValid() && !count($app['validator']->validate($entry))) {
            $entry->setAuthor($app['security']->getUsername());
            $repository = new EntryRepository($app['db']);
            $repository->insert($entry);
        }

    }

    return $app->redirect($app['url_generator']->generate('index'));

});
