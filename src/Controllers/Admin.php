<?php

namespace Kpacha\Dynsatis\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * The Admin controller
 *
 * @author Kpacha <kpacha666@gmail.com>
 */
class Admin
{

    public function index(Request $request, Application $app)
    {
        return $app['twig']->render('admin/index.html.twig', array('repos' => $app['repo_service']->getRepos()));
    }

    public function create(Request $request, Application $app)
    {
        return $app['twig']->render('admin/new.html.twig');
    }

    public function show(Request $request, Application $app, $repository)
    {
        return $app['twig']->render(
                        'admin/edit.html.twig',
                        $app['admin_form']->prepare($app['repo_service']->getRepoConfig($repository))
        );
    }

    public function save(Request $request, Application $app, $repository = null)
    {
        $app['repo_service']->save($app['admin_form']->parse($request), $repository);

        return $app->redirect('/');
    }

    public function build(Request $request, Application $app, $repository)
    {
        return $app['twig']->render(
                        'admin/build.html.twig',
                        $app['repo_service']->build($repository, $app['dynsatis.composer_home_path'])
        );
    }
}
