<?php

declare(strict_types=1);

use Content\Ports\Rest\Article\CreateArticleAction;
use Content\Ports\Rest\Article\ReadArticleAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// phpcs:disable SlevomatCodingStandard.Functions.StaticClosure.ClosureNotStatic -- router requires non-static callbacks
return static function (App $app): void {
//    $app->options('/{routes:.*}', static function (Request $request, Response $response) {
//        // CORS Pre-Flight OPTIONS Request Handler
//        return $response;
//    });

    $app->group('/articles', function (RouteCollectorProxy $group): void {
        $group->get('/{id}', ReadArticleAction::class);
        $group->post('', CreateArticleAction::class);
    });

//    $app->group('/users', static function (Group $group): void {
//        $group->get('', ListUsersAction::class);
//        $group->get('/{id}', ViewUserAction::class);
//    });
};
