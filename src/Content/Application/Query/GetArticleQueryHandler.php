<?php

declare(strict_types=1);

namespace Content\Application\Query;

use Content\Infra\Repository\ArticleRepository;

final class GetArticleQueryHandler
{
    public function __construct(private ArticleRepository $articleRepository)
    {
    }

    public function __invoke(GetArticleQuery $query): ?ArticleDTO
    {
        $article = $this->articleRepository->find($query->articleId);

        return isset($article) ? ArticleDTO::fromEntity($article) : null;
    }
}
