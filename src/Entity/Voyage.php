<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoyageRepository::class)]
class Voyage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Planet $planet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $purpose = null;

    #[ORM\Column]
    private ?bool $wormholeUpgrade = false;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $leaveAt;

    public function __construct()
    {
        $this->leaveAt = new \DateTimeImmutable('+1 month');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    public function setPlanet(?Planet $planet): static
    {
        $this->planet = $planet;

        return $this;
    }

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(string $purpose): static
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function isWormholeUpgrade(): ?bool
    {
        return $this->wormholeUpgrade;
    }

    public function setWormholeUpgrade(bool $wormholeUpgrade): static
    {
        $this->wormholeUpgrade = $wormholeUpgrade;

        return $this;
    }

    public function getLeaveAt(): ?\DateTimeImmutable
    {
        return $this->leaveAt;
    }

    public function setLeaveAt(\DateTimeImmutable $leaveAt): static
    {
        $this->leaveAt = $leaveAt;

        return $this;
    }
}
