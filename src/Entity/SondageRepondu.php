<?php

namespace App\Entity;

use App\Repository\SondageReponduRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SondageReponduRepository::class)
 */
class SondageRepondu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sondageRepondus")
     */
    private $sonde;

    /**
     * @ORM\ManyToOne(targetEntity=Sondage::class, inversedBy="sondageRepondus")
     */
    private $sondage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSonde(): ?User
    {
        return $this->sonde;
    }

    public function setSonde(?User $sonde): self
    {
        $this->sonde = $sonde;

        return $this;
    }

    public function getSondage(): ?Sondage
    {
        return $this->sondage;
    }

    public function setSondage(?Sondage $sondage): self
    {
        $this->sondage = $sondage;

        return $this;
    }
}
