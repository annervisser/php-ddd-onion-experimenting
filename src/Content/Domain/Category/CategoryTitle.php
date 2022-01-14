<?php

declare(strict_types=1);

namespace Content\Domain\Category;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

use function trim;

/** @psalm-immutable */
#[Embeddable]
final class CategoryTitle
{
    #[Column(name: 'title', length: 150)]
    protected readonly string $title;

    public function __construct(string $title)
    {
        $title = trim($title);
        Assert::minLength($title, 1);
        Assert::maxLength($title, 150);
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
