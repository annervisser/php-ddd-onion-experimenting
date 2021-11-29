<?php

declare(strict_types=1);

namespace ContentTest\Domain\Category;

use Content\Domain\Category\CategoryTitle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function str_repeat;

/** @covers \Content\Domain\Category\CategoryTitle */
class CategoryTitleTest extends TestCase
{
    public function testValidConstruct(): void
    {
        self::assertInstanceOf(CategoryTitle::class, new CategoryTitle('a'));
        self::assertInstanceOf(CategoryTitle::class, new CategoryTitle(str_repeat('a', 150)));
    }

    public function testConstructWithEmptyTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CategoryTitle('');
    }

    public function testConstructWithWhitespaceOnlyTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CategoryTitle('    ');
    }

    public function testConstructWithTitleThatIsTooLong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CategoryTitle(str_repeat('a', 151));
    }

    public function testGetTitle(): void
    {
        $title = new CategoryTitle('hello');
        self::assertEquals('hello', $title->getTitle());
    }
}
