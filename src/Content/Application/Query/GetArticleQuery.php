<?php

declare(strict_types=1);

namespace Content\Application\Query;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class GetArticleQuery
{
    public function __construct(public readonly UuidInterface $articleId)
    {
    }

    public static function fromString(string $uuidString): self
    {
        $uuid = Uuid::fromString($uuidString);

        return new self($uuid);
    }
}
