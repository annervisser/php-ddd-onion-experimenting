<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;

require __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/../config/bootstrap.php';

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Register middleware
$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request              = $serverRequestCreator->createServerRequestFromGlobals();

// Run App & Emit Response
$response        = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
