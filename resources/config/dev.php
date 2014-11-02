<?php

$app['debug'] = true;
$app['dynsatis.repo_path'] = __DIR__ . '/../../web/repo';
$app['dynsatis.templates_path'] = __DIR__ . '/../views';
$app['dynsatis.composer_home_path'] = __DIR__ . '/../composer';

return $app;