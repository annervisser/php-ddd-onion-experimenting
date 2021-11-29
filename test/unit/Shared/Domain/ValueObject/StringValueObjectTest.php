<?php

declare(strict_types=1);

namespace SharedTest\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\StringValueObject;

/** @covers \Shared\Domain\ValueObject\StringValueObject */
class StringValueObjectTest extends TestCase
{
    public function testEquals(): void
    {
        $value1 = $this->getInstance('value');
        $value2 = $this->getInstance('value');
        $value3 = $this->getInstance('different');
        self::assertTrue($value1->equals($value2));
        self::assertTrue($value2->equals($value1));
        self::assertFalse($value1->equals($value3));
        self::assertFalse($value2->equals($value3));
        self::assertFalse($value3->equals($value1));
    }

    private function getInstance(string $value): StringValueObject
    {
        return new /** @psalm-immutable */
        class ($value) extends StringValueObject {
            public function __construct(string $value)
            {
                parent::__construct($value);
            }
        };
    }
}
