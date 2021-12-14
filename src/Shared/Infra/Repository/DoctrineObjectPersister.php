<?php

declare(strict_types=1);

namespace Shared\Infra\Repository;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Ramsey\Uuid\UuidInterface;

use function sprintf;

class DoctrineObjectPersister implements ObjectPersisterInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    /** {@inheritDoc} */
    public function find(string $class, UuidInterface $id): ?object
    {
        return $this->em->find($class, $id);
    }

    /** {@inheritDoc} */
    public function get(string $class, UuidInterface $id): object
    {
        return $this->find($class, $id) ?? throw new LogicException(
            sprintf('Unable to get object with id %s', $id->toString())
        );
    }

    /** {@inheritDoc} */
    public function create(object $object): void
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    /** {@inheritDoc} */
    public function update(object $object): void
    {
        if (! $this->em->contains($object)) {
            throw new LogicException('Cannot store object not managed by entity manager');
        }

        $this->em->persist($object);
        $this->em->flush();
    }
}
