<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Shared\Infra\Settings\Settings;
use Shared\Infra\Settings\SettingsInterface;

$containerBuilder = new ContainerBuilder();

// Set up settings
$config      = require __DIR__ . '/config.php';
$settings    = new Settings($config);
$localConfig = __DIR__ . '/config.local.php';
if (file_exists($localConfig)) {
    $settings = $settings->addSettings(require $localConfig);
}

$containerBuilder->addDefinitions([SettingsInterface::class => $settings]);

// Set up container compilation
if ($settings->get('container.enableCompilation') !== false) {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up dependencies
foreach (glob(__DIR__ . '/dependencies/*.php') ?: [] as $dependencyFile) {
    $dependency = require $dependencyFile;
    assert(is_callable($dependency));
    ($dependency)($containerBuilder);
}

return $containerBuilder->build();
