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
    $containerBuilder->addDefinitions([
        LoggerInterface::class => static function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            assert($settings instanceof SettingsInterface);

            $logger = new Logger($settings->get('logger.name'));
            $logger->pushProcessor(new UidProcessor());

            $handler = new StreamHandler($settings->get('logger.path'), $settings->get('logger.level'));
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);
};
