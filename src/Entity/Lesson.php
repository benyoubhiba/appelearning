<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'id_lesson', targetEntity: Devoir::class)]
    private $devoirs;

    /*#[ORM\ManyToOne(targetEntity: Chapitre::class, inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_chapitre;*/

    public function __construct()
    {
        $this->devoirs = new ArrayCollection();
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
     * @return Collection<int, Devoir>
     */
    public function getDevoirs(): Collection
    {
        return $this->devoirs;
    }

    public function addDevoir(Devoir $devoir): self
    {
        if (!$this->devoirs->contains($devoir)) {
            $this->devoirs[] = $devoir;
            $devoir->setIdLesson($this);
        }

        return $this;
    }

    public function removeDevoir(Devoir $devoir): self
    {
        if ($this->devoirs->removeElement($devoir)) {
            // set the owning side to null (unless already changed)
            if ($devoir->getIdLesson() === $this) {
                $devoir->setIdLesson(null);
            }
        }

        return $this;
    }

    public function getIdChapitre(): ?Chapitre
    {
        return $this->id_chapitre;
    }

    public function setIdChapitre(?Chapitre $id_chapitre): self
    {
        $this->id_chapitre = $id_chapitre;

        return $this;
    }
}
