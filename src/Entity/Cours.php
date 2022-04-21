<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: User::class)]
    private $id_professeur;

    #[ORM\OneToOne(targetEntity: Forum::class, cascade: ['persist', 'remove'])]
    private $id_forum;

    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'cours')]
    private $id_classe;

    #[ORM\OneToMany(mappedBy: 'id_cours', targetEntity: Chapitre::class)]
    private $chapitres;

    #[ORM\OneToMany(mappedBy: 'id_cours', targetEntity: Avis::class)]
    private $avis;

    #[ORM\OneToOne(targetEntity: Certificat::class, cascade: ['persist', 'remove'])]
    private $id_certificat;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\File( "image/jpeg" , "image/png" , "image/tiff" , "image/svg+xml")]
    private $image;

    public function __construct()
    {
        $this->id_professeur = new ArrayCollection();
        $this->id_classe = new ArrayCollection();
        $this->chapitres = new ArrayCollection();
        $this->avis = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdProfesseur(): Collection
    {
        return $this->id_professeur;
    }

    public function addIdProfesseur(User $idProfesseur): self
    {
        if (!$this->id_professeur->contains($idProfesseur)) {
            $this->id_professeur[] = $idProfesseur;
            $idProfesseur->setCours($this);
        }

        return $this;
    }

    public function removeIdProfesseur(User $idProfesseur): self
    {
        if ($this->id_professeur->removeElement($idProfesseur)) {
            // set the owning side to null (unless already changed)
            if ($idProfesseur->getCours() === $this) {
                $idProfesseur->setCours(null);
            }
        }

        return $this;
    }

    public function getIdForum(): ?Forum
    {
        return $this->id_forum;
    }

    public function setIdForum(?Forum $id_forum): self
    {
        $this->id_forum = $id_forum;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getIdClasse(): Collection
    {
        return $this->id_classe;
    }

    public function addIdClasse(Classe $idClasse): self
    {
        if (!$this->id_classe->contains($idClasse)) {
            $this->id_classe[] = $idClasse;
        }

        return $this;
    }

    public function removeIdClasse(Classe $idClasse): self
    {
        $this->id_classe->removeElement($idClasse);

        return $this;
    }

    /**
     * @return Collection<int, Chapitre>
     */
    public function getChapitres(): Collection
    {
        return $this->chapitres;
    }

    public function addChapitre(Chapitre $chapitre): self
    {
        if (!$this->chapitres->contains($chapitre)) {
            $this->chapitres[] = $chapitre;
            $chapitre->setIdCours($this);
        }

        return $this;
    }

    public function removeChapitre(Chapitre $chapitre): self
    {
        if ($this->chapitres->removeElement($chapitre)) {
            // set the owning side to null (unless already changed)
            if ($chapitre->getIdCours() === $this) {
                $chapitre->setIdCours(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setIdCours($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getIdCours() === $this) {
                $avi->setIdCours(null);
            }
        }

        return $this;
    }

    public function getIdCertificat(): ?Certificat
    {
        return $this->id_certificat;
    }

    public function setIdCertificat(?Certificat $id_certificat): self
    {
        $this->id_certificat = $id_certificat;

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
