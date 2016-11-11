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

use Silex\Application;
use Silex\ServiceProviderInterface;

use PommProject\Foundation\Pomm;

/**
 * PommServiceProvider
 *
 * Silex ServiceProvider for Pomm2.
 *
 * @package PommServiceProvider
 * @copyright 2014 Grégoire HUBERT
 * @author Grégoire HUBERT
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see ServiceProviderInterface
 */
class PommServiceProvider implements ServiceProviderInterface
{
    /**
     * register
     *
     * @see ServiceProviderInterface
     */
    public function register(Application $app)
    {
        $app['pomm'] = $app->share(function () use ($app) {
            $pomm = new Pomm($app['pomm.configuration']);

            $service = isset($app['pomm.logger.service'])
                ? $app['pomm.logger.service']
                : 'monolog';

            if (isset($app[$service])) {
                $pomm->setLogger($app[$service]);
            }

            if (isset ($app['pomm.data_collector.configurator'])) {
                $app['pomm.data_collector.configurator']->configure($pomm);
            }

            return $pomm;
        });
    }

    /**
     * boot
     *
     * @see ServiceProviderInterface
     */
    public function boot(Application $app)
    {
    }
}
