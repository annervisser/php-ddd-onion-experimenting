<?php

declare(strict_types=1);

// Instantiate PHP-DI ContainerBuilder
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$prod = getenv('environment') === 'production';
if ($prod) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../config/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

return $containerBuilder->build();
