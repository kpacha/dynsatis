<?php

if (getenv('APPLICATION_ENV') == 'development') {
    require_once __DIR__ . '/../resources/config/dev.php';
} else {
    require_once __DIR__ . '/../resources/config/prod.php';
}

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['dynsatis.templates_path'],
));

$app['filesystem'] = function() {
            return new Symfony\Component\Filesystem\Filesystem;
        };

$app['finder'] = function() {
            return new \Symfony\Component\Finder\Finder;
        };

$app['repo_service'] = function($app) {
            return new Kpacha\Dynsatis\Services\Repository(
                            $app['dynsatis.repo_path'], $app['finder'], $app['filesystem'], $app['twig']
            );
        };

$app['admin_controller'] = function($app) {
            return new Kpacha\Dynsatis\Controllers\Admin;
        };

$app['admin_form'] = function($app) {
            return new Kpacha\Dynsatis\Forms\Admin;
        };

return $app;