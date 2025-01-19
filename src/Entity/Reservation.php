<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "Veuillez sélectionner une date")]
    #[Assert\GreaterThanOrEqual("today", message: "La date doit être aujourd'hui ou dans le futur")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank(message: "Veuillez sélectionner un créneau horaire")]
    private ?string $time = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez sélectionner un terrain")]
    #[Assert\Range(min: 1, max: 3, notInRangeMessage: "Le terrain doit être entre 1 et 3")]
    private ?int $court = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez indiquer le nombre de joueurs")]
    #[Assert\Range(min: 2, max: 4, notInRangeMessage: "Le nombre de joueurs doit être entre 2 et 4")]
    private ?int $players = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Admin $admin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): static
    {
        $this->time = $time;
        return $this;
    }

    public function getCourt(): ?int
    {
        return $this->court;
    }

    public function setCourt(int $court): static
    {
        $this->court = $court;
        return $this;
    }

    public function getPlayers(): ?int
    {
        return $this->players;
    }

    public function setPlayers(int $players): static
    {
        $this->players = $players;
        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): static
    {
        $this->admin = $admin;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
