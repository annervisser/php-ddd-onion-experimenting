<?php

declare(strict_types=1);

namespace ContentTest\Domain\Article;

use Content\Domain\Article\ArticleTitle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function str_repeat;

/** @covers \Content\Domain\Article\ArticleTitle */
class ArticleTitleTest extends TestCase
{
    public function testValidConstruct(): void
    {
        self::assertInstanceOf(ArticleTitle::class, new ArticleTitle('a'));
        self::assertInstanceOf(ArticleTitle::class, new ArticleTitle(str_repeat('a', 150)));
    }

    public function testConstructWithEmptyTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ArticleTitle('');
    }

    public function testConstructWithWhitespaceOnlyTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ArticleTitle('    ');
    }

    public function testConstructWithTitleThatIsTooLong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        self::assertInstanceOf(ArticleTitle::class, new ArticleTitle(str_repeat('a', 151)));
    }

    public function testGetTitle(): void
    {
        $title = new ArticleTitle('hello');
        self::assertEquals('hello', $title->getTitle());
    }
}
