<?php

declare(strict_types=1);

namespace Shared\Infra\Repository;

use Ramsey\Uuid\UuidInterface;

/**
 * @template E
 */
interface RepositoryInterface
{
    /** @return E|null */
    public function find(UuidInterface $id);

    /** @return E */
    public function get(UuidInterface $id);
}
