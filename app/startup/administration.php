<?php

use Silex\Application;

use SilexCMS\Form\TableType;

use Symfony\Component\HttpFoundation\Request;

$app->match('/administration/{table}', function (Application $app, Request $req, $table) {

    if (is_null($app['security']->getUsername()))
        return $app->redirect($app['url_generator']->generate('index'));

    $rows = array('rows' => $app['db']->fetchAll('SELECT * FROM ' . $table));
    $form = $app['form.factory']->create(new TableType($app, $table), $rows);

    if ($req->getMethod() === 'POST')
    {
        $form->bindRequest($req);
        if ($form->isValid())
        {
            $data = $form->getData();
            foreach ($data['rows'] as $row) {
                $where = array('id' => $row['id']);
                unset($row['id']);
                $app['db']->update($table, $row, $where);
            }
        }
    }

    return $app['twig']->render('administration.html.twig', array('table' => $table, 'form' => $form->createView()));

})->bind('administration');


$app->match('/administration', function(Application $app, Request $req) {

    if (is_null($app['security']->getUsername()))
        return $app->redirect($app['url_generator']->generate('index'));

    return $app['twig']->render('administration_hub.html.twig');

})->bind('administration_hub');