<?php

declare(strict_types=1);

namespace Content\Infra\Repository;

use Content\Domain\Article;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Ramsey\Uuid\UuidInterface;

use function sprintf;

class ArticleRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function find(UuidInterface $id): ?Article
    {
        return $this->em->find(Article::class, $id);
    }

    public function get(UuidInterface $id): Article
    {
        return $this->find($id) ?? throw new LogicException(
            sprintf('Unable to get Article with id %s', $id->toString())
        );
    }
}
