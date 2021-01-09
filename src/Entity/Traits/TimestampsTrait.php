<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait TimestampsTrait
{
    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var DateTimeImmutable
     *
     * @Groups({"user_read", "user_details_read", "article_read", "article_details_read"})
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     *
     * @Groups({"user_read", "user_details_read", "article_read", "article_details_read"})
     */
    private ?DateTimeInterface $updatedAt;

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAtValue(): self
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
