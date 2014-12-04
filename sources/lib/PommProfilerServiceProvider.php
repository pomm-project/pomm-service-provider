<?php
/*
 * This file is part of Pomm's Silex™ ServiceProvider package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\Silex\ServiceProvider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use PommProject\Silex\ServiceProvider\DatabaseDataCollector;

use Symfony\Bridge\Twig\Extension\YamlExtension;

/**
 * PommProfilerServiceProvider
 *
 * Silex ServiceProvider for Pomm profiler.
 *
 * @package PommServiceProvider
 * @copyright 2014 Grégoire HUBERT
 * @author Jérôme MACIAS
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see ServiceProviderInterface
 */
class PommProfilerServiceProvider implements ServiceProviderInterface
{
    /**
     * register
     *
     * @see ServiceProviderInterface
     */
    public function register(Container $app)
    {
        $app->extend('data_collectors', function ($collectors, $app) {
            $collectors['db'] = function ($app) {
                return new DatabaseDataCollector($app['pomm']);
            };

            return $collectors;
        });

        $app['data_collector.templates'] = array_merge(
            $app['data_collector.templates'],
            [['db', '@Pomm/Profiler/db.html.twig']]
        );

        $app['twig'] = $app->extend('twig', function ($twig, $app) {
            if (!$twig->hasExtension('yaml')) {
                $twig->addExtension(new YamlExtension());
            }

            return $twig;
        });

        $app->extend('twig.loader.filesystem', function ($loader, $app) {
            $loader->addPath($app['pomm.templates_path'], 'Pomm');

            return $loader;
        });

        $app['pomm.templates_path'] = function () {
            $r = new \ReflectionClass('PommProject\Silex\ServiceProvider\DatabaseDataCollector');

            return dirname(dirname(dirname($r->getFileName()))).'/views';
        };
    }
}
