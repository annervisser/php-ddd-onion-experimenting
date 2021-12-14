<?php

declare(strict_types=1);

namespace Content\Ports\Rest\Article;

use Content\Application\Command\Article\CreateArticleCommand;
use Content\Application\Command\Article\CreateArticleCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Shared\Ports\Rest\JsonSerializer;
use Shared\Ports\Rest\RestAction;
use Webmozart\Assert\Assert;

final class CreateArticleAction implements RestAction
{
    public function __construct(
        private readonly CreateArticleCommandHandler $createArticleCommandHandler,
        private readonly JsonSerializer $jsonSerializer
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $requestData = $request->getParsedBody();
        Assert::isArray($requestData);
        $categoryId = Uuid::fromString((string) $requestData['categoryId']);
        $command    = new CreateArticleCommand($categoryId, (string) $requestData['title']);
        $articleId  = ($this->createArticleCommandHandler)($command);

        return $this->jsonSerializer->setJsonBody(['articleId' => $articleId], $response);
    }
}
