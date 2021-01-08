<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleTest extends AbstractEndpoint
{
    public function testGetArticles(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/articles');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }
}
