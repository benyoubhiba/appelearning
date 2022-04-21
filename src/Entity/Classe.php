<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'classes')]
    private $enseignant;

    #[ORM\ManyToMany(targetEntity: Aprennant::class, mappedBy: 'classe')]
    private $aprennants;

    #[ORM\ManyToMany(targetEntity: Cours::class, mappedBy: 'id_classe')]
    private $cours;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\File( "image/jpeg" , "image/png" , "image/tiff" , "image/svg+xml")]
    private $image;

    public function __construct()
    {
        $this->aprennants = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEnseignant(): ?User
    {
        return $this->enseignant;
    }

    public function setEnseignant(?User $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * @return Collection<int, Aprennant>
     */
    public function getAprennants(): Collection
    {
        return $this->aprennants;
    }

    public function addAprennant(Aprennant $aprennant): self
    {
        if (!$this->aprennants->contains($aprennant)) {
            $this->aprennants[] = $aprennant;
            $aprennant->addClasse($this);
        }

        return $this;
    }

    public function removeAprennant(Aprennant $aprennant): self
    {
        if ($this->aprennants->removeElement($aprennant)) {
            $aprennant->removeClasse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->addIdClasse($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            $cour->removeIdClasse($this);
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
