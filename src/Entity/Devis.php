<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\Column]
    private ?float $montantHorsTva = null;

    #[ORM\Column]
    private ?int $TauxTva = null;

    #[ORM\Column(nullable: true)]
    private ?float $benefice = null;

    #[ORM\Column(nullable: true)]
    private ?int $accomptePourcent = null;

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

    public function getAccomptePourcent(): ?int
    {
        return $this->accomptePourcent;
    }

    public function setAccomptePourcent(?int $accomptePourcent): static
    {
        $this->accomptePourcent = $accomptePourcent;

        return $this;
    }
}
