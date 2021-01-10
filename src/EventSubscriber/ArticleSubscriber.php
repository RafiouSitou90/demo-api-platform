<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use App\Service\Authorizations\ArticleAuthorizationChecker;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ArticleSubscriber implements EventSubscriberInterface
{
    private array $methodsNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET,
    ];
    private ArticleAuthorizationChecker $articleAuthorizationChecker;

    public function __construct(ArticleAuthorizationChecker $articleAuthorizationChecker)
    {
        $this->articleAuthorizationChecker = $articleAuthorizationChecker;
    }

    public function check(ViewEvent $event): void
    {
        $article = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($article instanceof Article && !in_array($method, $this->methodsNotAllowed, true)) {
            $this->articleAuthorizationChecker->check($article, $method);
            $article->setUpdatedAt(new DateTime('now'));
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_WRITE]
        ];
    }
}
