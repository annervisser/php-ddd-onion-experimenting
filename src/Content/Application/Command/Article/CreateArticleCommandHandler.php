<?php

declare(strict_types=1);

namespace Content\Application\Command\Article;

use Content\Domain\Article;
use Content\Domain\Article\ArticleTitle;
use Content\Infra\Repository\ArticleRepository;
use Content\Infra\Repository\CategoryRepository;
use Ramsey\Uuid\UuidInterface;

final class CreateArticleCommandHandler
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function __invoke(CreateArticleCommand $command): UuidInterface
    {
        $category = $this->categoryRepository->get($command->categoryId);
        $article  = Article::create($category, new ArticleTitle($command->title));
        $this->articleRepository->create($article);

        return $article->getId();
    }
}
