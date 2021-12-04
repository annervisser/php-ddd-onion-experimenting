<?php

declare(strict_types=1);

namespace Content\Application\Query;

use Content\Domain\Article;
use DateTimeInterface;

/** @psalm-immutable */
final class ArticleDTO
{
    private function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $categoryId,
        public readonly string $createdAt
    ) {
    }

    public static function fromEntity(Article $article): self
    {
        return new self(
            $article->getId()->toString(),
            $article->getTitle()->getTitle(),
            $article->getCategory()->getId()->toString(),
            $article->getCreatedAt()->format(DateTimeInterface::ATOM)
        );
    }
}
