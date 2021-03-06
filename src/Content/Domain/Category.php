<?php

declare(strict_types=1);

namespace Content\Domain;

use Content\Domain\Category\CategoryTitle;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Domain\EntityInterface;

#[Entity]
class Category implements EntityInterface
{
    #[Id, Column(type: 'uuid_binary_ordered_time')]
    private UuidInterface $id;

    #[Column]
    private DateTimeImmutable $createdAt;

    #[ManyToOne]
    private ?Category $parent;

    #[Embedded(columnPrefix: false)]
    private CategoryTitle $title;

    private function __construct(?Category $parent, CategoryTitle $title)
    {
        $this->title     = $title;
        $this->parent    = $parent;
        $this->id        = Uuid::uuid1();
        $this->createdAt = new DateTimeImmutable();
    }

    public static function createRootCategory(CategoryTitle $title): self
    {
        return new self(null, $title);
    }

    public static function createChildCategory(Category $parent, CategoryTitle $title): self
    {
        return new self($parent, $title);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @psalm-assert-if-false !null $this->parent
     * @psalm-assert-if-true null $this->parent
     */
    public function isRootCategory(): bool
    {
        return ! isset($this->parent);
    }

    public function moveTo(Category $parent): void
    {
        $this->parent = $parent;
    }

    public function moveToRoot(): void
    {
        $this->parent = null;
    }

    public function getTitle(): CategoryTitle
    {
        return $this->title;
    }

    public function changeTitle(CategoryTitle $title): void
    {
        $this->title = $title;
    }
}
