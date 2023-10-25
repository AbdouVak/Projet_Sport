<?php

namespace App\Entity;

use App\Repository\SeanceExerciceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceExerciceRepository::class)]
class SeanceExercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $serie = null;

    #[ORM\Column(nullable: true)]
    private ?int $poid = null;

    #[ORM\ManyToOne(inversedBy: 'seanceExercices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercice $exercice = null;

    #[ORM\ManyToOne(inversedBy: 'seanceExercices')]
    private ?Seance $seance = null;

    #[ORM\Column(nullable: true)]
    private ?int $repetition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerie(): ?int
    {
        return $this->serie;
    }

    public function setSerie(?int $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getPoid(): ?int
    {
        return $this->poid;
    }

    public function setPoid(?int $poid): static
    {
        $this->poid = $poid;

        return $this;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(?int $repetition): static
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): static
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;

        return $this;
    }
}
