# Pomm Service Provider

This package contains a [Pomm](http://www.pomm-project.org) ServiceProvider for the [Silex](http://silex.sensiolabs.org) micro-framework.

## Installation

To install this library, run the command below:

```bash
    composer require pomm-project/pomm-service-provider ~2.0@dev
```

And enable it in your application:

```php
<?php

use PommProject\Silex\ServiceProvider as PommProvider;
// …
$app->register(new PommProvider\PommServiceProvider(),
    [
        'pomm.configuration' =>
        [
            'my_db1' => ['dsn' => 'pgsql://user:pass@host:port/db_name'],
            'my_db2' => 
                [
                    'dsn' => … ,
                    'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
                ],
            …
        ],
        'pomm.logger.service' => 'monolog', // default
    ]
);
```

This package also contain a `PommProfilerServiceProvider` to be used with the [`WebProfileProvider`](https://github.com/silexphp/Silex-WebProfiler).

```php
<?php

use PommProject\Silex\ServiceProvider as PommProvider;
// …
$app->register(new PommProvider\PommProfilerServiceProvider());
```

If you want to use the `ModelManager` package, be sure to specify either the model manager `SessionBuilder` or, better: your project session builder.

## Usage

```php
<?php
// …
$iterator = $app['pomm']['my_db']
    ->getQueryManager()
    ->query('select …', ['param1', 'param2', … ]);
```

Check out

 * [Foundation documentation](https://github.com/pomm-project/Foundation/blob/master/README.md)
 * [Model Manager documentation](https://github.com/pomm-project/ModelManager/blob/master/README.md)
 * [Cli documentation](https://github.com/pomm-project/Cli/blob/master/README.md)
