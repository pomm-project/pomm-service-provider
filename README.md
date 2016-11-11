# Pomm Service Provider

[![Monthly Downloads](https://poser.pugx.org/pomm-project/pomm-service-provider/d/monthly.png)](https://packagist.org/packages/pomm-project/pomm-service-provider) [![License](https://poser.pugx.org/pomm-project/pomm-service-provider/license.svg)](https://packagist.org/packages/pomm-project/pomm-service-provider)

This package contains a [Pomm2](http://www.pomm-project.org) ServiceProvider for the [Silex](http://silex.sensiolabs.org/) micro-framework version 2.x. You can access the provider for Silex 1.x on the [dev-silex-1](https://github.com/pomm-project/pomm-profiler-service-provider/tree/silex-1) of this project.

## Installation

Here is a sample `composer.json` file:

```json
{
        "require": {
            "pomm-project/pomm-service-provider":   "dev-silex-2",
            "pomm-project/cli":                     "2.0.*@dev",
            "pomm-project/model-manager":           "2.0.*@dev",
            "pomm-project/foundation":              "2.0.*@dev",
            "silex/silex":                          "~2.0"
        }
}
```

## Setup

```php
<?php
// …
$app->register(new PommProject\Silex\ServiceProvider\PommServiceProvider(),
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
