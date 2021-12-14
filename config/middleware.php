<?php

declare(strict_types=1);

use Shared\Infra\Settings\SettingsInterface;
use Slim\App;

/** @psalm-suppress UnusedClosureParam */
return static function (App $app): void {
    $settings = $app->getContainer()?->get(SettingsInterface::class);
    assert($settings instanceof SettingsInterface);

    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware(
        $settings->get('displayErrorDetails'),
        $settings->get('logError'),
        $settings->get('logErrorDetails')
    );
};
