<?php

declare(strict_types=1);

namespace Content\Infra\Repository;

use Content\Domain\Article;
use Shared\Infra\Repository\AbstractRepository;
use Shared\Infra\Repository\ObjectPersisterInterface;

/** @template-extends AbstractRepository<Article> */
class ArticleRepository extends AbstractRepository
{
    public function __construct(ObjectPersisterInterface $persister)
    {
        parent::__construct(Article::class, $persister);
    }
}
