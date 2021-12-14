<?php

declare(strict_types=1);

namespace Content\Infra\Repository;

use Content\Domain\Category;
use Shared\Infra\Repository\AbstractRepository;
use Shared\Infra\Repository\ObjectPersisterInterface;

/** @template-extends AbstractRepository<Category> */
class CategoryRepository extends AbstractRepository
{
    public function __construct(ObjectPersisterInterface $persister)
    {
        parent::__construct(Category::class, $persister);
    }
}
