<?php

declare(strict_types=1);

namespace Content\Ports\Rest\Article;

use Content\Application\Query\Article\GetArticleQuery;
use Content\Application\Query\Article\GetArticleQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shared\Ports\Rest\JsonSerializer;
use Shared\Ports\Rest\RestAction;
use Slim\Exception\HttpNotFoundException;
use Webmozart\Assert\Assert;

use function sprintf;

final class ReadArticleAction implements RestAction
{
    public function __construct(
        private readonly GetArticleQueryHandler $getArticleQueryHandler,
        private readonly JsonSerializer $jsonSerializer
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws HttpNotFoundException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        Assert::string($args['id']);
        $id = $args['id'];
        Assert::uuid($id);
        $query   = GetArticleQuery::fromString($id);
        $article = ($this->getArticleQueryHandler)($query);
        if (! isset($article)) {
            throw new HttpNotFoundException(
                $request,
                sprintf('Article with uuid %s not found', $query->articleId->toString())
            );
        }

        return $this->jsonSerializer->setJsonBody($article, $response);
    }
}
