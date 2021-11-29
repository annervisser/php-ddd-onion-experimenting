<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;
use Shared\Infra\Settings\Settings;
use Shared\Infra\Settings\SettingsInterface;

return static function (ContainerBuilder $containerBuilder): void {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            SettingsInterface::class => static function () {
                return new Settings(
                    [
                        'displayErrorDetails' => true, // Should be set to false in production
                        'logError' => false,
                        'logErrorDetails' => false,
                        'logger' => [
                            'name' => 'slim-app',
                            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                            'level' => Logger::DEBUG,
                        ],
                    ]
                );
            },
        ]
    );
};
