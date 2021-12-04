<?php

declare(strict_types=1);

namespace Shared\Ports\Rest;

use JsonException;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;
use Shared\Ports\Rest\Exceptions\SerializationFailedException;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class JsonSerializer
{
    public function setJsonBody(mixed $data, ResponseInterface $response): ResponseInterface
    {
        try {
            $json = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new SerializationFailedException('Failed to serialize data to JSON', 0, $e);
        }

        $stream = Stream::create($json);

        return $response->withBody($stream)->withHeader('Content-Type', 'application/json');
    }
}
