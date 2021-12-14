<?php

declare(strict_types=1);

namespace Content\Application\Command\Article;

use Ramsey\Uuid\UuidInterface;

final class CreateArticleCommand
{
    public function __construct(
        public readonly UuidInterface $categoryId,
        public readonly string $title,
    ) {
    }
}
