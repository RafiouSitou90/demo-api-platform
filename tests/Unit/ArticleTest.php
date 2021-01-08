<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Article;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    protected Article $article;

    protected function setUp(): void
    {
        parent::setUp();
        $this->article = new Article();
    }

    public function testGetName(): void
    {
        $value = 'Article test name';
        $this->article->setName($value);
        self::assertSame($value, $this->article->getName());
    }

    public function testGetContent(): void
    {
        $value = 'Article test content';
        $this->article->setContent($value);
        self::assertSame($value, $this->article->getContent());
    }

    public function testGetAuthor(): void
    {
        $value = new User();
        $this->article->setAuthor($value);
        self::assertInstanceOf(User::class, $this->article->getAuthor());
    }
}
