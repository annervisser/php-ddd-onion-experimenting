<?php

declare(strict_types=1);

namespace ContentTest\Application\Query\Article;

use Content\Application\Query\Article\GetArticleQuery;
use Content\Application\Query\Article\GetArticleQueryHandler;
use Content\Domain\Article;
use Content\Domain\Category;
use Content\Infra\Repository\ArticleRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/** @covers \Content\Application\Query\Article\GetArticleQueryHandler */
class GetArticleQueryHandlerTest extends TestCase
{
    public function testInvokeWithValidUuid(): void
    {
        $article = $this->getArticle();
        $handler = $this->getHandler($article);
        $query   = new GetArticleQuery($article->getId());
        $result  = $handler($query);
        self::assertNotNull($result);
        self::assertEquals($article->getId()->toString(), $result->id);
    }

    public function testInvokeWithUnknownUuid(): void
    {
        $handler = $this->getHandler();
        $query   = new GetArticleQuery(Uuid::uuid1());
        $result  = $handler($query);
        self::assertNull($result);
    }

    private function getArticle(): Article
    {
        return Article::create(
            Category::createRootCategory(new Category\CategoryTitle('cat')),
            new Article\ArticleTitle('articletitle')
        );
    }

    private function getHandler(?Article $article = null): GetArticleQueryHandler
    {
        $mock = $this->createMock(ArticleRepository::class);
        if ($article) {
            $mock->method('find')->with($article->getId())->willReturn($article);
        }

        $mock->method('find')->willReturn(null);

        return new GetArticleQueryHandler($mock);
    }
}
