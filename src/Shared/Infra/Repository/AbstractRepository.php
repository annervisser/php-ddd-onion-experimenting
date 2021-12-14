<?php

declare(strict_types=1);

namespace Shared\Infra\Repository;

use Ramsey\Uuid\UuidInterface;

/**
 * @template T of object
 * @template-implements RepositoryInterface<T>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /** @param class-string<T> $className */
    protected function __construct(
        private readonly string $className,
        private readonly ObjectPersisterInterface $persister
    ) {
    }

    /** @return T|null */
    public function find(UuidInterface $id): ?object
    {
        return $this->persister->find($this->className, $id);
    }

    /** @return T */
    public function get(UuidInterface $id): object
    {
        return $this->persister->get($this->className, $id);
    }

    /** @param T $object */
    public function create(object $object): void
    {
        $this->persister->create($object);
    }

    /** @param T $object */
    public function update(object $object): void
    {
        $this->persister->update($object);
    }
}
