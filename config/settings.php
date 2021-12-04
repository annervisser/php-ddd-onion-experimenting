<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;
use Shared\Infra\Settings\Settings;
use Shared\Infra\Settings\SettingsInterface;

return static function (ContainerBuilder $containerBuilder): void {
    $appRoot = __DIR__ . '/..';

    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            SettingsInterface::class => static function () use ($appRoot) {
                return new Settings(
                    [
                        'displayErrorDetails' => true, // Should be set to false in production
                        'logError' => false,
                        'logErrorDetails' => false,
                        'logger' => [
                            'name' => 'slim-app',
                            'path' => isset($_ENV['docker']) ? 'php://stdout' : $appRoot . '/logs/app.log',
                            'level' => Logger::DEBUG,
                        ],
                        'doctrine' => [
                            // if true, metadata caching is forcefully disabled
                            'dev_mode' => true,

                            // path where the compiled metadata info will be cached
                            // make sure the path exists and it is writable
                            'cache_dir' => $appRoot . '/var/doctrine',

                            // you should add any other path containing annotated entity classes
                            'metadata_dirs' => [$appRoot . '/src/Content/Domain'],

                            'connection' => [
                                'driver' => 'pdo_mysql',
                                'host' => '127.0.0.1',
                                'port' => 3306,
                                'dbname' => 'slim_ddd',
                                'user' => 'root',
                                'password' => 'toor',
                            ],
                        ],
                    ]
                );
            },
        ]
    );
};
