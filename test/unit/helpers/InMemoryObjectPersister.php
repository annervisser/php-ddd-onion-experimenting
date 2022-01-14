<?php

declare(strict_types=1);

namespace UnitTestHelpers;

use LogicException;
use Ramsey\Uuid\UuidInterface;
use Shared\Domain\EntityInterface;
use Shared\Infra\Repository\ObjectPersisterInterface;
use Webmozart\Assert\Assert;

use function get_class;

class InMemoryObjectPersister implements ObjectPersisterInterface
{
    /** @var array<class-string, array<string, mixed>> */
    private array $data = [];

    public function find(string $class, UuidInterface $id): ?object
    {
        $entity = $this->data[$class][$id->toString()] ?? null;
        Assert::nullOrIsInstanceOf($entity, $class);

        return $entity;
    }

    public function get(string $class, UuidInterface $id): object
    {
        return $this->find($class, $id) ?? throw new LogicException('Not found');
    }

    /** {@inheritDoc} */
    public function create(object $object): void
    {
        Assert::isInstanceOf($object, EntityInterface::class);
        $this->store($object->getId()->toString(), $object);
    }

    public function update(object $object): void
    {
        Assert::isInstanceOf($object, EntityInterface::class);
        $id = $object->getId()->toString();
        $this->find($object::class, $object->getId()) ?? throw new LogicException(
            'cannot update unmanaged entity'
        );
        $this->store($id, $object);
    }

    private function store(string $id, object $object): void
    {
        $class                   = get_class($object);
        $this->data[$class]    ??= [];
        $this->data[$class][$id] = clone $object;
    }
}
