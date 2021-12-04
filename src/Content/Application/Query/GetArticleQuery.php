<?php

declare(strict_types=1);

namespace Content\Application\Query;

use Ramsey\Uuid\Rfc4122\FieldsInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class GetArticleQuery
{
    public function __construct(public readonly UuidInterface $articleId)
    {
    }

    public static function fromString(string $uuidString): self
    {
        Assert::uuid($uuidString);
        $uuid    = Uuid::fromString($uuidString);
        $fields  = $uuid->getFields();
        $version = $fields instanceof FieldsInterface ? $fields->getVersion() : -1;
        Assert::eq($version, 1, 'Expected v1 uuid');

        return new self($uuid);
    }
}
