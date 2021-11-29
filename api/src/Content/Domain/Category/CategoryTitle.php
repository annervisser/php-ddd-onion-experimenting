<?php

declare(strict_types=1);

namespace Content\Domain\Category;

use Doctrine\ORM\Mapping\Column;
use Shared\Domain\ValueObject\StringValueObject;
use Webmozart\Assert\Assert;

use function trim;

/** @psalm-immutable */
final class CategoryTitle extends StringValueObject
{
    #[Column(name: 'title', length: 150)]
    protected readonly string $value;

    public function __construct(string $title)
    {
        $title = trim($title);
        Assert::minLength($title, 1);
        Assert::maxLength($title, 150);
        parent::__construct($title);
    }

    public function getTitle(): string
    {
        return $this->value;
    }
}
