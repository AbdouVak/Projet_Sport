<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: SeanceExercice::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $seanceExercices;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'seanceFavoris')]
    private Collection $favorisUsers;


  
    public function __construct()
    {
        $this->seanceExercices = new ArrayCollection();
        $this->favorisUsers = new ArrayCollection();
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
            $seanceExercice->setSeance($this);
        }

        return $this;
    }

    public function removeSeanceExercice(SeanceExercice $seanceExercice): static
    {
        if ($this->seanceExercices->removeElement($seanceExercice)) {
            // set the owning side to null (unless already changed)
            if ($seanceExercice->getSeance() === $this) {
                $seanceExercice->setSeance(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->nom;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
        }

        return $this;
    }

    public function nbrExercice(): int
    {
        return count($this->getSeanceExercices());
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavorisUsers(): Collection
    {
        return $this->favorisUsers;
    }

    public function addFavorisUser(User $favorisUser): static
    {
        if (!$this->favorisUsers->contains($favorisUser)) {
            $this->favorisUsers->add($favorisUser);
            $favorisUser->addSeanceFavori($this);
        }

        return $this;
    }

    public function removeFavorisUser(User $favorisUser): static
    {
        if ($this->favorisUsers->removeElement($favorisUser)) {
            $favorisUser->removeSeanceFavori($this);
        }

        return $this;
    }

    public function nbrFavoris(): int
    {
        return count($this->getFavorisUsers());
    }
}
