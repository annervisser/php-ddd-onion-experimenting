<?php

declare(strict_types=1);

namespace Content\Domain;

use Content\Domain\Article\ArticleTitle;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Domain\EntityInterface;

#[Entity]
final class Article implements EntityInterface
{
    #[Id, Column(type: 'uuid_binary_ordered_time')]
    private UuidInterface $id;

    #[Column]
    private DateTimeImmutable $createdAt;

    #[OneToMany]
    private Category $category;

    #[Embedded]
    private ArticleTitle $title;

    private function __construct(
        Category $category,
        ArticleTitle $title
    ) {
        $this->category  = $category;
        $this->title     = $title;
        $this->id        = Uuid::uuid6();
        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(
        Category $category,
        ArticleTitle $title
    ): self {
        return new self($category, $title);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getTitle(): ArticleTitle
    {
        return $this->title;
    }

    public function changeTitle(ArticleTitle $title): void
    {
        $this->title = $title;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function moveTo(Category $category): void
    {
        $this->category = $category;
    }
}
