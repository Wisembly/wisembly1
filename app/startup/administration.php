<?php

use Silex\Application;

use SilexCMS\Form\TableType;
use SilexCMS\Response\TransientResponse;

use Symfony\Component\HttpFoundation\Request;
use SilexCMS\Repository\GenericRepository;

$app->match('/administration/{table}', function (Application $app, Request $req, $table) {

    if (is_null($app['security']->getUsername())) {
        return $app->redirect($app['url_generator']->generate('index'));
    }

    $repository = new GenericRepository($app['db'], $table);
    $rows = $repository->findAll();

    foreach ($rows as $row) {
        $data[] = array_map(function($val) {
            return is_string($val) ? substr(strip_tags($val), 0, 47) . '...' : $val;
        }, $row);
    }

    return new TransientResponse($app['twig'], 'administration.html.twig', array('table' => $table, 'fields' => $repository->getSchema(), 'rows' => $data));
})
->bind('administration');

$app->match('/administration/{table}/{id}', function (Application $app, Request $req, $table, $id) {

    if (is_null($app['security']->getUsername())) {
        return $app->redirect($app['url_generator']->generate('index'));
    }

    if (!is_numeric($id) && 'new' !== $id) {
        throw new \Exception("Wrong parameters");
    }

    $repository = new GenericRepository($app['db'], $table);

    if ('new' === $id) {
        $rows = array('rows' => array(array_map(function ($val) { return null; }, $repository->getSchema())));
    } else {
        $rows = array('rows' => $repository->fetchall("SELECT * FROM `{$table}` WHERE id = {$id}"));
    }

    $form = $app['form.factory']->create(new TableType($app, $table), $rows);

    if ($req->getMethod() === 'POST') {
        $form->bindRequest($req);

        if ($form->isValid()) {
            $data = $form->getData();

            foreach ($data['rows'] as $row) {
                $where = array('id' => $row['id']);
                unset($row['id']);

                if ('new' === $id) {
                    $repository->insert($row);

                    return $app->redirect($app['url_generator']->generate('administration', array('table' => $table)));
                } else {
                    $repository->update($row, $where);
                }
            }
        }
    }

    return new TransientResponse($app['twig'], 'administration_edit.html.twig', array(
        'table' => $table,
        'id'    => $id,
        'form'  => $form->createView()
    ));
})
->bind('administration_edit');

$app->match('/administration', function(Application $app, Request $req) {

    if (is_null($app['security']->getUsername())) {
        return $app->redirect($app['url_generator']->generate('index'));
    }

    $tables = $app['db']->fetchAll('SHOW tables');
    $listTables = array();

    foreach ($tables as $table) {
        $listTables[] = array_shift($table);
    }

    return new TransientResponse($app['twig'], 'administration_hub.html.twig', array('tables' => $listTables));
})
->bind('administration_hub');