# Pomm Service Provider

This package contains a Pomm ServiceProvider for the [Silex](http://silex.sensiolabs.org/) micro-framework.

## Installation

Here is a sample `composer.json` file:

```json
{
        "require": {
            "pomm-project/pomm-service-provider":   "dev-master",
            "pomm-project/cli":                     "dev-master",
            "pomm-project/model-manager":           "dev-master",
            "pomm-project/foundation":              "dev-master",
            "silex/silex":                          "1.2.*"
        }
}
```

## Setup

```php
<?php
// …
$app->register(new PommServiceProvider(), 
    [
        'pomm.configuration' =>
        [
            'my_db1' => ['dsn' => … ],
            'my_db2' => ['dsn' => … ],
            …
        ],
    ]
);
```

In case there is a logger that implements the standard `Psr\Logger` interface, it is possible to tell Pomm the name of the service using the `pomm.logger.service` parameter (`monolog` by default).

## Use it

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
