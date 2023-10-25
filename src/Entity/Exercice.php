<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: CategorieMuscle::class, inversedBy: 'exercices')]
    private Collection $CategorieMuscles;

    #[ORM\OneToMany(mappedBy: 'exercice', targetEntity: SeanceExercice::class)]
    private Collection $seanceExercices;

    public function __construct()
    {
        $this->CategorieMuscles = new ArrayCollection();
        $this->seanceExercices = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, CategorieMuscle>
     */
    public function getCategorieMuscles(): Collection
    {
        return $this->CategorieMuscles;
    }

    public function addCategorieMuscle(CategorieMuscle $categorieMuscle): static
    {
        if (!$this->CategorieMuscles->contains($categorieMuscle)) {
            $this->CategorieMuscles->add($categorieMuscle);
        }

        return $this;
    }

    public function removeCategorieMuscle(CategorieMuscle $categorieMuscle): static
    {
        $this->CategorieMuscles->removeElement($categorieMuscle);

        return $this;
    }

    /**
     * @return Collection<int, SeanceExercice>
     */
    public function getSeanceExercices(): Collection
    {
        return $this->seanceExercices;
    }

    public function addSeanceExercice(SeanceExercice $seanceExercice): static
    {
        if (!$this->seanceExercices->contains($seanceExercice)) {
            $this->seanceExercices->add($seanceExercice);
            $seanceExercice->setExercice($this);
        }

        return $this;
    }

    public function removeSeanceExercice(SeanceExercice $seanceExercice): static
    {
        if ($this->seanceExercices->removeElement($seanceExercice)) {
            // set the owning side to null (unless already changed)
            if ($seanceExercice->getExercice() === $this) {
                $seanceExercice->setExercice(null);
            }
        }

        return $this;
    }


}
