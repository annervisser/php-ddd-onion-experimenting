<?php

declare(strict_types=1);

namespace ContentTest\Application\Query\Article;

use Content\Application\Query\Article\ArticleDTO;
use Content\Domain\Article;
use Content\Domain\Category;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

/** @covers \Content\Application\Query\Article\ArticleDTO */
class ArticleDTOTest extends TestCase
{
    public function testFromEntity(): void
    {
        $category = Category::createRootCategory(new Category\CategoryTitle('title'));
        $article  = Article::create($category, new Article\ArticleTitle('articletitle'));
        $dto      = ArticleDTO::fromEntity($article);
        self::assertEquals($category->getId()->toString(), $dto->categoryId);
        self::assertEquals($article->getId()->toString(), $dto->id);
        self::assertEquals($article->getTitle()->getTitle(), $dto->title);
        self::assertEquals($article->getCreatedAt()->format(DateTimeInterface::ATOM), $dto->createdAt);
    }
}
