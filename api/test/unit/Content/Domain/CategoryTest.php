<?php

declare(strict_types=1);

namespace ContentTest\Domain;

use Content\Domain\Category;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/** @covers \Content\Domain\Category */
class CategoryTest extends TestCase
{
    private function createRootCategory(string $title = 'categorytitle'): Category
    {
        return Category::createRootCategory(new Category\CategoryTitle($title));
    }

    private function createChildCategory(Category $parent, string $title = 'categorytitle'): Category
    {
        return Category::createChildCategory($parent, new Category\CategoryTitle($title));
    }

    public function testCreateRootCategory(): void
    {
        $category = $this->createRootCategory();
        self::assertInstanceOf(Category::class, $category);
        self::assertTrue($category->isRootCategory());
    }

    public function testCreateChildCategory(): void
    {
        $rootCategory  = $this->createRootCategory();
        $childCategory = $this->createChildCategory($rootCategory);
        self::assertInstanceOf(Category::class, $childCategory);
        self::assertFalse($childCategory->isRootCategory());
        self::assertEquals($rootCategory, $childCategory->getParent());
    }

    public function testMoveTo(): void
    {
        $rootCategory1 = $this->createRootCategory();
        $rootCategory2 = $this->createRootCategory();
        $childCategory = $this->createChildCategory($rootCategory1);
        $childCategory->moveTo($rootCategory2);
        self::assertEquals($rootCategory2, $childCategory->getParent());
    }

    public function testMoveToRoot(): void
    {
        $rootCategory  = $this->createRootCategory();
        $childCategory = $this->createChildCategory($rootCategory);
        $childCategory->moveToRoot();
        self::assertTrue($childCategory->isRootCategory());
    }

    public function testGetTitle(): void
    {
        self::assertEquals('title1', $this->createRootCategory('title1')->getTitle()->getTitle());
    }

    public function testGetId(): void
    {
        self::assertTrue(Uuid::isValid($this->createRootCategory()->getId()->toString()));
    }

    public function testChangeTitle(): void
    {
        $category = $this->createRootCategory();
        $category->changeTitle(new Category\CategoryTitle('title2'));
        self::assertEquals('title2', $category->getTitle()->getTitle());
    }

    public function testGetCreatedAt(): void
    {
        self::assertInstanceOf(DateTimeImmutable::class, $this->createRootCategory()->getCreatedAt());
    }
}
