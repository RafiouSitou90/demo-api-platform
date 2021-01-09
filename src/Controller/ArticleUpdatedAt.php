<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use DateTime;

class ArticleUpdatedAt
{
    public function __invoke(Article $data): Article
    {
        $data->setUpdatedAt(new DateTime('tomorrow'));

        return $data;
    }
}
