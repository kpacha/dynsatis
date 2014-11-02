<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', 'Kpacha\Dynsatis\Controllers\Home::index');

$app->get('/admin/new-repository', 'Kpacha\Dynsatis\Controllers\Admin::create');

$app->post('/admin/new-repository', 'Kpacha\Dynsatis\Controllers\Admin::save');

$app->get('/admin/{repository}/build',
        function (Request $request, $repository) use ($app) {
            return $app['admin_controller']->build($request, $app, $repository);
        });

$app->get('/admin/{repository}', 
        function (Request $request, $repository) use ($app) {
            return $app['admin_controller']->show($request, $app, $repository);
        });

$app->post('/admin/{repository}', 
        function (Request $request, $repository) use ($app) {
            return $app['admin_controller']->save($request, $app, $repository);
        });

$app->get('/admin', 'Kpacha\Dynsatis\Controllers\Admin::index');

return $app;