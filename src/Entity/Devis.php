<?php

namespace App\Entity;

use DateTime;
use DateTimeZone;
use DateTimeImmutable;
use App\Entity\Clients;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DevisRepository;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $endDate;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $etat = null;

    #[ORM\Column]
    private ?float $montantHorsTva = null;

    #[ORM\Column]
    private ?int $TauxTva = null;

    #[ORM\Column(nullable: true)]
    private ?float $benefice = null;

    #[ORM\Column(nullable: true)]
    private ?float $accompte = null;

    #[ORM\ManyToOne(targetEntity: Clients::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    



    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('Europe/Brussels'));
        $this->etat = 'NOUVEAU';
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): static
    {
        $this->texte = $texte;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }


    public function getMontantHorsTva(): ?float
    {
        return $this->montantHorsTva;
    }

    public function setMontantHorsTva(float $montantHorsTva): static
    {
        $this->montantHorsTva = $montantHorsTva;

        return $this;
    }

    public function getTauxTva(): ?int
    {
        return $this->TauxTva;
    }

    public function setTauxTva(int $TauxTva): static
    {
        $this->TauxTva = $TauxTva;

        return $this;
    }

    public function getBenefice(): ?float
    {
        return $this->benefice;
    }

    public function setBenefice(?float $benefice): static
    {
        $this->benefice = $benefice;

        return $this;
    }

    public function getAccompte(): ?float
    {
        return $this->accompte;
    }

    public function setAccompte(?float $accompte): static
    {
        $this->accompte = $accompte;

        return $this;
    }
}
