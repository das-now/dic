# PHP Dependency Injection Container PSR-11

*PHP version required 7.3*

**How to use ?**

``` php
// services.php
<?php

use Psr\Container\ContainerInterface;

return [
    'database.host' => '127.0.0.1',
    'database.port' => null,
    'database.name' => '',
    'database.user' => 'root',
    'database.password' => null,
    'google.key' => 'YQ4FcwaXD165Xm72lx53qzzNzkz7AUUN',
    PDO::class => static function (ContainerInterface $container) {
        return new PDO(
            sprintf('mysql:host=%s;dbname=%s;', $container->get('database.host'), $container->get('database.name')),
            $container->get('database.user'),
            $container->get('database.password'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    },
];
```

``` php
<?php

use DevCoder\DependencyInjection\Container;

$services = require 'services.php';
$container = new Container($services);

var_dump($container->get(PDO:class));
// object(PDO)[18]


var_dump($container->get('google.key'));
// YQ4FcwaXD165Xm72lx53qzzNzkz7AUUN
```
Ideal for small project
Simple and easy!
[https://github.com/devcoder-xyz/php-dependency-injection](https://github.com/devcoder-xyz/php-dependency-injection)

**How can we improve this object?**
* add autowire option to Auto resolution of constructor parameters
