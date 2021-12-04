<?php

declare(strict_types=1);

namespace Shared\Ports\Rest;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RestAction
{
    /**
     * @param array<string, mixed> $args
     * @no-named-arguments
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface;
}
