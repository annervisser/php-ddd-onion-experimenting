<?php

declare(strict_types=1);

namespace Content\Domain\Article;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Shared\Domain\ValueObject\StringValueObject;
use Webmozart\Assert\Assert;

use function trim;

/** @psalm-immutable */
#[Embeddable]
final class ArticleTitle extends StringValueObject
{
    #[Column(name: 'title', type: 'string', length: 150)]
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
