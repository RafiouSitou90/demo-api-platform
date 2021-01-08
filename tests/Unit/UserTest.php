<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Article;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function testGetEmail(): void
    {
        $value = 'test@test.com';

        $this->user->setEmail($value);
        $email = $this->user->getEmail();

        self::assertSame($value, $email);
        self::assertSame($value, $this->user->getUsername());
    }

    public function testGetRoles(): void
    {
        $value = ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];
        $this->user->setRoles($value);
        self::assertContainsEquals('ROLE_USER', $this->user->getRoles());
        self::assertContainsEquals('ROLE_ADMIN', $this->user->getRoles());
        self::assertContainsEquals('ROLE_SUPER_ADMIN', $this->user->getRoles());
    }

    public function testGetPassword(): void
    {
        $value = 'password';
        $this->user->setPassword($value);
        self::assertSame($value, $this->user->getPassword());
    }

    public function testGetArticles(): void
    {
        $value = new Article();
        $this->user->addArticle($value);
        self::assertCount(1, $this->user->getArticles());
        self::assertTrue($this->user->getArticles()->contains($value));

        $this->user->removeArticle($value);
        self::assertCount(0, $this->user->getArticles());
        self::assertFalse($this->user->getArticles()->contains($value));
    }
}
