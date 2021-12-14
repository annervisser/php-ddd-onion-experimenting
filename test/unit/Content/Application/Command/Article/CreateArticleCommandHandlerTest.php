<?php

declare(strict_types=1);

namespace ContentTest\Application\Command\Article;

use Content\Application\Command\Article\CreateArticleCommand;
use Content\Application\Command\Article\CreateArticleCommandHandler;
use Content\Domain\Article;
use Content\Domain\Category;
use Content\Infra\Repository\ArticleRepository;
use Content\Infra\Repository\CategoryRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

/** @covers \Content\Application\Command\Article\CreateArticleCommandHandler */
class CreateArticleCommandHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $category  = Category::createRootCategory(new Category\CategoryTitle('categoryTitle'));
        $handler   = new CreateArticleCommandHandler(
            $this->getArticleRepositoryMock(),
            $this->getCategoryRepositoryMock($category)
        );
        $command   = new CreateArticleCommand($category->getId(), 'article title');
        $articleId = $handler($command);
        self::assertInstanceOf(UuidInterface::class, $articleId);
    }

    private function getArticleRepositoryMock(): ArticleRepository
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $articleRepository->expects($this->once())
            ->method('create')
            ->with(
                $this->callback(
                    static fn (Article $article) => $article->getTitle()->getTitle() === 'article title'
                )
            );

        return $articleRepository;
    }

    private function getCategoryRepositoryMock(Category $category): CategoryRepository
    {
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->method('get')->willReturn($category);
        $categoryRepository->expects($this->once())
            ->method('get')
            ->with($category->getId());

        return $categoryRepository;
    }
}
