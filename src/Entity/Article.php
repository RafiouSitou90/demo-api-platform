<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ArticleUpdatedAt;
use App\Entity\Traits\ResourceIdTrait;
use App\Entity\Traits\TimestampsTrait;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"article_read"}}
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"article_details_read"}}
 *          },
 *          "post",
 *          "put",
 *          "patch",
 *          "delete",
 *          "put_updated_at"={
 *              "method"="PUT",
 *              "path"="/articles/{id}/updated-at",
 *              "controller"=ArticleUpdatedAt::class,
 *          }
 *     }
 * )
 */
class Article
{
    use ResourceIdTrait;
    use TimestampsTrait;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"article_read", "user_details_read", "article_details_read"})
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"article_read", "user_details_read"})
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"article_details_read"})
     */
    private ?User $author;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
