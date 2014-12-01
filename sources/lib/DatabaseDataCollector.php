<?php

namespace PommProject\Silex\ServiceProvider;

use PommProject\Foundation\Listener\Listener;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DatabaseDataCollector extends DataCollector
{
    private $queries;

    public function __construct(Pomm $pomm)
    {
        $this->queries = [];

        foreach ($pomm->getSessionBuilders() as $name => $builder) {
            $listener = new Listener('query');
            $listener->attachAction(array($this, 'execute'));

            $pomm->getSession($name)->registerClient($listener);
        }
    }

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

    public function getQueries()
    {
        return $this->data['queries'];
    }

    public function getQuerycount()
    {
        return $this->data['querycount'];
    }

    public function getTime()
    {
        return $this->data['time'];
    }

    public function getName()
    {
        return 'db';
    }
}
