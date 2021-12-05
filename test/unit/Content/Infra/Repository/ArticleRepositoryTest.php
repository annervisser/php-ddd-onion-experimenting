<?php

declare(strict_types=1);

namespace ContentTest\Infra\Repository;

use Content\Domain\Article;
use Content\Domain\Category;
use Content\Infra\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/** @covers \Content\Infra\Repository\ArticleRepository */
class ArticleRepositoryTest extends TestCase
{
    private static UuidInterface $articleId;

    public static function setUpBeforeClass(): void
    {
        self::$articleId = Uuid::uuid6();
        parent::setUpBeforeClass();
    }

    public function testFind(): void
    {
        $repository = $this->getRepository();
        self::assertInstanceOf(Article::class, $repository->find(self::$articleId));
        self::assertNull($repository->find(Uuid::uuid6()));
    }

    public function testGet(): void
    {
        $repository = $this->getRepository();
        self::assertInstanceOf(Article::class, $repository->get(self::$articleId));
        $this->expectException(LogicException::class);
        $repository->get(Uuid::uuid6());
    }

    private function getRepository(): ArticleRepository
    {
        $emMock  = $this->createMock(EntityManager::class);
        $article = Article::create(
            Category::createRootCategory(new Category\CategoryTitle('cat')),
            new Article\ArticleTitle('articletitle')
        );
        $emMock->method('find')->willReturnCallback(
            /** @psalm-suppress UnusedClosureParam we need to match EntityManager::find() */
            static fn (string $class, UuidInterface $uuid) => $uuid->equals(self::$articleId) ? $article : null
        );

        return new ArticleRepository($emMock);
    }
}
