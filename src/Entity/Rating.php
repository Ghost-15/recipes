<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRated = null;

    #[ORM\Column]
    private ?bool $star = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDateRated(): ?\DateTimeInterface
    {
        return $this->dateRated;
    }

    public function setDateRated(\DateTimeInterface $dateRated): static
    {
        $this->dateRated = $dateRated;

        return $this;
    }

    public function isStar(): ?bool
    {
        return $this->star;
    }

    public function setStar(bool $star): static
    {
        $this->star = $star;

        return $this;
    }
}
