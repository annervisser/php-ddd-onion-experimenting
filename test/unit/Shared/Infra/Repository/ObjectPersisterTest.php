<?php

declare(strict_types=1);

namespace SharedTest\Infra\Repository;

use Content\Domain\Article;
use Content\Domain\Category;
use Doctrine\ORM\EntityManager;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Domain\EntityInterface;
use Shared\Infra\Repository\DoctrineObjectPersister;

/** @covers \Shared\Infra\Repository\DoctrineObjectPersister */
class ObjectPersisterTest extends TestCase
{
    private static UuidInterface $articleId;

    public static function setUpBeforeClass(): void
    {
        self::$articleId = Uuid::uuid4();
        parent::setUpBeforeClass();
    }

    public function testFind(): void
    {
        $persister = $this->getPersister();
        self::assertInstanceOf(Article::class, $persister->find(Article::class, self::$articleId));
        self::assertNull($persister->find(Article::class, Uuid::uuid4()));
    }

    public function testGet(): void
    {
        $persister = $this->getPersister();
        self::assertInstanceOf(Article::class, $persister->get(Article::class, self::$articleId));
        $this->expectException(LogicException::class);
        $persister->get(Article::class, Uuid::uuid4());
    }

    public function testCreate(): void
    {
        $em      = $this->getMockEm();
        $article = Article::create(
            Category::createRootCategory(new Category\CategoryTitle('category-title')),
            new Article\ArticleTitle('article-title')
        );
        $em->expects($this->once())->method('persist')->with($article);
        $em->expects($this->once())->method('flush');
        $persister = new DoctrineObjectPersister($em);
        $persister->create($article);
    }

    public function testUpdate(): void
    {
        $em        = $this->getMockEm();
        $persister = new DoctrineObjectPersister($em);
        $article   = $persister->get(Article::class, self::$articleId);
        $em->expects($this->once())->method('persist')->with($article);
        $em->expects($this->once())->method('flush');
        $persister->update($article);
    }

    private function getPersister(): DoctrineObjectPersister
    {
        return new DoctrineObjectPersister($this->getMockEm());
    }

    /**
     * @uses MockObject phpcs doesnt recognise usage in type
     *
     * @return EntityManager & MockObject
     */
    private function getMockEm(): EntityManager|MockObject
    {
        $emMock          = $this->createMock(EntityManager::class);
        $article         = Article::create(
            Category::createRootCategory(new Category\CategoryTitle('cat')),
            new Article\ArticleTitle('article-title')
        );
        self::$articleId = $article->getId();
        $emMock->method('find')->willReturnCallback(
        /** @psalm-suppress UnusedClosureParam we need to match EntityManager::find() */
            static fn (string $class, UuidInterface $uuid) => $uuid->equals(self::$articleId) ? $article : null
        );
        $emMock->method('contains')->willReturnCallback(
            static fn (EntityInterface $object) => $object->getId()->equals(self::$articleId)
        );

        return $emMock;
    }
}
