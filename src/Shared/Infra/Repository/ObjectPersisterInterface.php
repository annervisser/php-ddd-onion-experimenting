<?php

declare(strict_types=1);

namespace Shared\Infra\Repository;

use Ramsey\Uuid\UuidInterface;

interface ObjectPersisterInterface
{
    /**
     * @psalm-param class-string<T> $class
     * @phpstan-param class-string<T> $class
     *
     * @psalm-return T|null
     * @phpstan-return T|null
     *
     * @psalm-template T of object
     * @phpstan-template T of object
     */
    public function find(string $class, UuidInterface $id): ?object;

    /**
     * @psalm-param class-string<T> $class
     * @phpstan-param class-string<T> $class
     *
     * @psalm-return T
     * @phpstan-return T
     *
     * @psalm-template T of object
     * @phpstan-template T of object
     */
    public function get(string $class, UuidInterface $id): object;

    /**
     * @psalm-param T $object
     * @phpstan-param T $object
     *
     * @psalm-template T of object
     * @phpstan-template T of object
     */
    public function create(object $object): void;

    /**
     * @psalm-param T $object
     * @phpstan-param T $object
     *
     * @psalm-template T of object
     * @phpstan-template T of object
     */
    public function update(object $object): void;
}
