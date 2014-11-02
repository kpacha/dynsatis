<?php

namespace Kpacha\Dynsatis\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * The Home controller
 *
 * @author Kpacha <kpacha666@gmail.com>
 */
class Home
{
    public function index(Request $request, Application $app)
    {
        return $app['twig']->render('index.html.twig', array('repos' => $app['repo_service']->getRepos()));
    }
}
