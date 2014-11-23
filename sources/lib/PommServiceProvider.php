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

use PommProject\Foundation\Pomm;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * PommServiceProvider
 *
 * Silex ServiceProvider for Pomm.
 *
 * @package PommServiceProvider
 * @copyright 2014 Grégoire HUBERT
 * @author Grégoire HUBERT
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see ServiceProviderInterface
 */
class PommServiceProvider implements  ServiceProviderInterface
{
   /**
    * register
    *
    * @see ServiceProviderInterface
    */
   public function register(Application $app)
   {
       $app['pomm'] = $app->share(function($c) {
           $pomm = new Pomm($c['pomm.configuration']);

           $service = isset($c['pomm.logger.service'])
               ? $c['pomm.logger.service']
               : 'monolog'
               ;

           if (isset($c[$service])) {
               $pomm->setLogger($c[$service]);
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
