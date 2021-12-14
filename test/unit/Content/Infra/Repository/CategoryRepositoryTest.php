<?php

declare(strict_types=1);

namespace ContentTest\Infra\Repository;

use Content\Domain\Category;
use Content\Infra\Repository\CategoryRepository;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use UnitTestHelpers\InMemoryObjectPersister;

/** @covers \Content\Infra\Repository\CategoryRepository */
class CategoryRepositoryTest extends TestCase
{
    private static Category $category;

    public static function setUpBeforeClass(): void
    {
        self::$category = Category::createRootCategory(new Category\CategoryTitle('cat'));
        parent::setUpBeforeClass();
    }

    public function testFind(): void
    {
        $repository = $this->getRepository();
        self::assertInstanceOf(Category::class, $repository->find(self::$category->getId()));
        self::assertNull($repository->find(Uuid::uuid1()));
    }

    public function testGet(): void
    {
        $repository = $this->getRepository();
        self::assertInstanceOf(Category::class, $repository->get(self::$category->getId()));
        $this->expectException(LogicException::class);
        $repository->get(Uuid::uuid1());
    }

    private function getRepository(): CategoryRepository
    {
        $persister = new InMemoryObjectPersister();
        $persister->create(self::$category);

        return new CategoryRepository($persister);
    }
}
