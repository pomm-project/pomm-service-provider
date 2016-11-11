<?php

use \Silex\Provider\TwigServiceProvider;
use \Silex\Provider\WebProfilerServiceProvider;
use \Silex\Provider\UrlGeneratorServiceProvider;
use \Silex\Provider\HttpFragmentServiceProvider;
use \Silex\Provider\ServiceControllerServiceProvider;
use \PommProject\Silex\ServiceProvider\PommServiceProvider;
use \PommProject\Silex\ProfilerServiceProvider\PommProfilerServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

if (!is_file(__DIR__ . '/config/config.php')) {
    throw new \RunTimeException('No current configuration file found in config.');
}

$app['config'] = require __DIR__ . '/config/config.php';

$app['debug'] = $app['config']['debug'];

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/views',
]);

$app->register(new PommServiceProvider(), [
    'pomm.configuration' => $app['config']['pomm'],
]);

if (class_exists('\Silex\Provider\WebProfilerServiceProvider')) {
    $app->register(new UrlGeneratorServiceProvider);
    $app->register(new ServiceControllerServiceProvider);
    $app->register(new HttpFragmentServiceProvider);

    $app->register(new WebProfilerServiceProvider, [
        'profiler.cache_dir' => __DIR__ . '/../cache/profiler',
        'profiler.mount_prefix' => '/_profiler',
    ]);

    $app->register(new PommProfilerServiceProvider);
}

return $app;
