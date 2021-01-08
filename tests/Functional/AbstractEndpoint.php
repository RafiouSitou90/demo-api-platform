<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndpoint extends WebTestCase
{
    protected KernelBrowser $client;
    private array $server = [
        'ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function getResponseFromRequest(string $method, string $uri, ?string $payload = null): Response
    {
        $this->client->request(
            $method,
            $uri.'.json',
            [],
            [],
            $this->server,
            $payload
        );

        return $this->client->getResponse();
    }
}
