<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $prixtotal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixtotal(): ?int
    {
        return $this->prixtotal;
    }

    public function setPrixtotal(int $prixtotal): self
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }
}
