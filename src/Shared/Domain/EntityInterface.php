<?php

declare(strict_types=1);

namespace Shared\Domain;

use Ramsey\Uuid\UuidInterface;

interface EntityInterface
{
    public function getId(): UuidInterface;
}
