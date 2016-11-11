<?php

use \Symfony\Component\HttpFoundation\Request;

$app = require __DIR__ . '/bootstrap.php';

$app->get('/', function(Request $request) use($app) {
    $result = $app['pomm']['test']->getQueryManager()
        ->query('select 1');

    return $app['twig']->render('index.html.twig');
});

return $app;
