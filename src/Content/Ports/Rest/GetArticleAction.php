<?php

declare(strict_types=1);

namespace Content\Ports\Rest;

use Content\Application\Query\GetArticleQuery;
use Content\Application\Query\GetArticleQueryHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shared\Ports\Rest\JsonSerializer;
use Shared\Ports\Rest\RestAction;
use Slim\Exception\HttpNotFoundException;
use Webmozart\Assert\Assert;

use function sprintf;

final class GetArticleAction implements RestAction
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
