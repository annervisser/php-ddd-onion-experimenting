<?php

declare(strict_types=1);

use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require_once __DIR__ . '/bootstrap.php';
assert($container instanceof Container);

return ConsoleRunner::createHelperSet($container->get(EntityManager::class));
