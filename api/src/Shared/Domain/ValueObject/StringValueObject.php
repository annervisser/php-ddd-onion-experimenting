<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

/** @psalm-immutable */
abstract class StringValueObject
{
    protected readonly string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
