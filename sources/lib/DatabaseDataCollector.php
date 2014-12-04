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

use PommProject\Foundation\Listener\Listener;
use PommProject\Foundation\Session\Session;
use PommProject\Foundation\Pomm;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * DatabaseDataCollector
 *
 * Data collector for the database profiler.
 *
 * @package PommServiceProvider
 * @copyright 2014 Grégoire HUBERT
 * @author Jérôme MACIAS
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see DataCollector
 */
class DatabaseDataCollector extends DataCollector
{
    private $queries;

    /**
     * __construct
     *
     * Attach profiler actions to each query builder.
     *
     * @access  public
     * @param   Pomm $pomm
     * @return  null
     */
    public function __construct(Pomm $pomm)
    {
        $this->queries = [];

        foreach ($pomm->getSessionBuilders() as $name => $builder) {
            $listener = new Listener('query');
            $listener->attachAction(array($this, 'execute'));

            $pomm->getSession($name)->registerClient($listener);
        }
    }

    /**
     * execute
     *
     * Action attached to the query listener.
     * It attaches each new query in a query stack.
     *
     * @access public
     * @param  name     event name
     * @param  array    $data
     * @param  Session  $session
     * @return null
     */
    public function execute($name, $data, Session $session)
    {
        if (!in_array($name, array('query:pre', 'query:post'))) {
            return;
        }

        if ('query:post' === $name) {
            end($this->queries);
            $key = key($this->queries);
            reset($this->queries);

            $this->queries[$key] += $data;

            return;
        }

        $this->queries[] = $data;
    }

    /**
     * collect
     *
     * Prepare data for the collector.
     *
     * @access public
     * @param  Request $request
     * @param  Response $response
     * @param  \Exception $exception
     * @return null
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $time = 0;
        $querycount = 0;
        $queries = $this->queries;

        foreach ($queries as $query) {
            ++$querycount;
            $time += $query['time_ms'];
        }

        $this->data = compact('queries', 'querycount', 'time');
    }

    /**
     * getQueries
     *
     * Return the list of queries sent.
     *
     * @access public
     * @return array
     */
    public function getQueries()
    {
        return $this->data['queries'];
    }

    /**
     * getQuerycount
     *
     * Return the number of queries sent.
     *
     * @access public
     * @return integer
     */
    public function getQuerycount()
    {
        return $this->data['querycount'];
    }

    /**
     * getTime
     *
     * Return queries total time.
     *
     * @access public
     * @return float
     */
    public function getTime()
    {
        return $this->data['time'];
    }

    /**
     * getName
     *
     * Return profiler identifier.
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'db';
    }
}
