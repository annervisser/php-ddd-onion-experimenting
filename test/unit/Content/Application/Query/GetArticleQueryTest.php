<?php

declare(strict_types=1);

namespace ContentTest\Application\Query;

use Content\Application\Query\GetArticleQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/** @covers \Content\Application\Query\GetArticleQuery */
class GetArticleQueryTest extends TestCase
{
    public function testFromString(): void
    {
        $uuid1 = Uuid::uuid1();
        $query = GetArticleQuery::fromString($uuid1->toString());
        self::assertEquals($uuid1->toString(), $query->articleId->toString());

        $this->expectException(InvalidArgumentException::class);
        GetArticleQuery::fromString('this is not a uuid');
    }

    public function testConstruct(): void
    {
        $uuid1 = Uuid::uuid1();
        $query = new GetArticleQuery($uuid1);
        self::assertEquals($uuid1->toString(), $query->articleId->toString());
    }
}
