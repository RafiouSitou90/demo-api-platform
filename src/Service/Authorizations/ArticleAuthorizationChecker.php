<?php

declare(strict_types=1);

namespace App\Service\Authorizations;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleAuthorizationChecker
{
    private array $methodsNotAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
    ];
    /**
     * @var User|UserInterface|null
     */
    private ?User $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function check(Article $article, string $method): void
    {
        $this->isAuthenticated();

        if ($this->isMethodAllowed($method) && $article->getAuthor()->getId() !== $this->user->getId()) {
            $errorMessage = "It's not your resource";
            throw new UnauthorizedHttpException($errorMessage, "Access denied!!! " . $errorMessage);
        }
    }

    private function isAuthenticated(): void
    {
        if (null === $this->user) {
            $errorMessage = "You are not authenticated";
            throw new UnauthorizedHttpException($errorMessage, "Access denied!!! " . $errorMessage);
        }
    }

    private function isMethodAllowed(string $method): bool
    {
        return in_array($method, $this->methodsNotAllowed, true);
    }
}
