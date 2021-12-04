<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Shared\Infra\Settings\SettingsInterface;

return static function (ContainerBuilder $containerBuilder): void {
    $doctrine = require __DIR__ . '/dependencies/doctrine.php';
    ($doctrine)($containerBuilder);

    $containerBuilder->addDefinitions([
        LoggerInterface::class => static function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            assert($settings instanceof SettingsInterface);

            $loggerSettings = $settings->get('logger');
            $logger         = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);
};
