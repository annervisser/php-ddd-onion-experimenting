<?php

declare(strict_types=1);

namespace ContentTest\Application\Command\Article;

use Content\Application\Command\Article\CreateArticleCommand;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/** @covers \Content\Application\Command\Article\CreateArticleCommand */
class CreateArticleCommandTest extends TestCase
{
    public function testConstruct(): void
    {
        $command = new CreateArticleCommand(Uuid::uuid4(), 'article title');
        self::assertEquals('article title', $command->title);
    }
}
