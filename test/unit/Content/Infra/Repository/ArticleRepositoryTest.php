<?php

declare(strict_types=1);

namespace ContentTest\Infra\Repository;

use Content\Domain\Article;
use Content\Domain\Category;
use Content\Infra\Repository\ArticleRepository;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use UnitTestHelpers\InMemoryObjectPersister;

/**
 * @covers \Content\Infra\Repository\ArticleRepository
 * @covers \Shared\Infra\Repository\AbstractRepository
 */
class ArticleRepositoryTest extends TestCase
{
    private static Article $article;

    public static function setUpBeforeClass(): void
    {
        self::$article = self::getArticle();
        parent::setUpBeforeClass();
    }

    public function testFind(): void
    {
        $repository = $this->getRepository();
        self::assertInstanceOf(Article::class, $repository->find(self::$article->getId()));
        self::assertNull($repository->find(Uuid::uuid1()));
    }

    public function testGet(): void
    {
        $repository = $this->getRepository();
        self::assertInstanceOf(Article::class, $repository->get(self::$article->getId()));
        $this->expectException(LogicException::class);
        $repository->get(Uuid::uuid1());
    }

    public function testCreate(): void
    {
        $repo    = $this->getRepository();
        $article = self::getArticle();
        $repo->create($article);
        self::assertNotNull($repo->find($article->getId()));
        self::assertEquals($article, $repo->get($article->getId()));
    }

    public function testUpdate(): void
    {
        $repo    = $this->getRepository();
        $article = self::getArticle();
        $repo->create($article);
        $article->changeTitle(new Article\ArticleTitle('changedtitle'));
        self::assertSame(
            $repo->get($article->getId())->getTitle()->getTitle(),
            'articletitle',
            'Title should not have been updated yet'
        );
        $repo->update($article);
        self::assertSame(
            $repo->get($article->getId())->getTitle()->getTitle(),
            'changedtitle',
            'Title should be updated after calling update()'
        );
    }

    private function getRepository(): ArticleRepository
    {
        $persister = new InMemoryObjectPersister();
        $persister->create(self::$article);

        return new ArticleRepository($persister);
    }

    private static function getArticle(): Article
    {
        return Article::create(
            Category::createRootCategory(new Category\CategoryTitle('cat')),
            new Article\ArticleTitle('articletitle')
        );
    }
}
