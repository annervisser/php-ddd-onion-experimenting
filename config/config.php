<?php

declare(strict_types=1);

use Monolog\Logger;

$appRoot = __DIR__ . '/..';

return [
    'environment' => getenv('APP_ENVIRONMENT') ?: 'prod',
    'displayErrorDetails' => false, // Should be set to false in production
    'logError' => false,
    'logErrorDetails' => false,
    'container' => ['enableCompilation' => true],
    'logger' => [
        'name' => 'slim-app',
        'path' => isset($_ENV['docker']) ? 'php://stdout' : $appRoot . '/logs/app.log',
        'level' => Logger::DEBUG,
    ],
    'doctrine' => [
        // if true, metadata caching is forcefully disabled
        'dev_mode' => false,

        // path where the compiled metadata info will be cached
        // make sure the path exists and it is writable
        'cache_dir' => $appRoot . '/var/doctrine',

        // you should add any other path containing annotated entity classes
        'metadata_dirs' => [$appRoot . '/src/Content/Domain'],

        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => getenv('MYSQL_HOST'),
            'port' => getenv('MYSQL_PORT'),
            'dbname' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USERNAME'),
            'password' => getenv('MYSQL_PASSWORD'),
        ],
    ],
];
