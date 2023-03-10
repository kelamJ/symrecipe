<?php

namespace App\Entity;

use App\Repository\TierlistRepository;
use Doctrine\ORM\Mapping as ORM;

//Vérification avec les asserts
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TierlistRepository::class)]
class Tierlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    //Vérification avec les asserts
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 25)]
    //Vérification avec les asserts
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 25)]
    private ?string $type = null;

    #[ORM\Column]
    //Vérification avec les asserts
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    /*Constructeur*/
    public function __construct()
{
    $this->createdAt = new \DateTimeImmutable();
}
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
