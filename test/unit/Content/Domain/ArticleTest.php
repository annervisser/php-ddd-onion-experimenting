<?php

declare(strict_types=1);

namespace ContentTest\Domain;

use Content\Domain\Article;
use Content\Domain\Category;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers \Content\Domain\Article
 */
class ArticleTest extends TestCase
{
    private function createArticle(string $title = 'articletitle'): Article
    {
        $category = Category::createRootCategory(new Category\CategoryTitle('category1'));

        return Article::create($category, new Article\ArticleTitle($title));
    }

    public function testCreate(): void
    {
        self::assertInstanceOf(Article::class, $this->createArticle());
    }

    public function testGetTitle(): void
    {
        self::assertEquals('title1', $this->createArticle('title1')->getTitle()->getTitle());
    }

    public function testGetId(): void
    {
        self::assertTrue(Uuid::isValid($this->createArticle()->getId()->toString()));
    }

    public function testMoveTo(): void
    {
        $category = Category::createRootCategory(new Category\CategoryTitle('category'));
        $article  = $this->createArticle();
        $article->moveTo($category);
        self::assertEquals($category, $article->getCategory());
    }

    public function testGetCreatedAt(): void
    {
        self::assertInstanceOf(DateTimeImmutable::class, $this->createArticle()->getCreatedAt());
    }

    public function testChangeTitle(): void
    {
        $article = $this->createArticle();
        $article->changeTitle(new Article\ArticleTitle('title1'));
        self::assertEquals('title1', $article->getTitle()->getTitle());
    }

    public function testGetCategory(): void
    {
        self::assertInstanceOf(Category::class, $this->createArticle()->getCategory());
    }
}
