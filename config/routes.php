<?php

declare(strict_types=1);

use Content\Infra\HelloWorldHandler;
use Slim\App;

/** @psalm-suppress UnusedClosureParam */
return static function (App $app): void {
//    $app->options('/{routes:.*}', static function (Request $request, Response $response) {
//        // CORS Pre-Flight OPTIONS Request Handler
//        return $response;
//    });

    $app->get('/', HelloWorldHandler::class);

//    $app->group('/users', static function (Group $group): void {
//        $group->get('', ListUsersAction::class);
//        $group->get('/{id}', ViewUserAction::class);
//    });
};
