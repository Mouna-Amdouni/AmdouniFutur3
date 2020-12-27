<?php

namespace App\Entity;

use App\Repository\SondageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SondageRepository::class)
 */
class Sondage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;
/**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbParticipant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbQuestion;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sondages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enqueteur;

    /**
     * @ORM\ManyToOne(targetEntity=Sujet::class, inversedBy="sondages")
     */
    private $sujet;

   

    /**
     * @ORM\OneToMany(targetEntity=QuestionChoixMultiples::class, mappedBy="sondage")
     */
    private $questionChoixMultiples;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="sondage")
     */
    private $questions;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $remun;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $misEnLigne;

    /**
     * @ORM\OneToOne(targetEntity=Cadeau::class, inversedBy="sondage", cascade={"persist", "remove"})
     */
    private $cadeau;

    /**
     * @ORM\OneToOne(targetEntity=Remise::class, inversedBy="sondage", cascade={"persist", "remove"})
     */
    private $remise;

      /**
     * @ORM\OneToMany(targetEntity=SondageRepondu::class, mappedBy="sondage")
     */
    private $sondageRepondus;
/**
     * @ORM\Column(type="string", length=255)
     */
    private $AdrRecup;
    public function __construct()
    {
       
        $this->questionChoixMultiples = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->sondageRepondus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbParticipant(): ?int
    {
        return $this->nbParticipant;
    }

    public function setNbParticipant(?int $nbParticipant): self
    {
        $this->nbParticipant = $nbParticipant;

        return $this;
    }

    public function getNbQuestion(): ?int
    {
        return $this->nbQuestion;
    }

    public function setNbQuestion(int $nbQuestion): self
    {
        $this->nbQuestion = $nbQuestion;

        return $this;
    }

    public function getEnqueteur(): ?User
    {
        return $this->enqueteur;
    }

    public function setEnqueteur(?User $enqueteur): self
    {
        $this->enqueteur = $enqueteur;

        return $this;
    }

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

   

    /**
     * @return Collection|QuestionChoixMultiples[]
     */
    public function getQuestionChoixMultiples(): Collection
    {
        return $this->questionChoixMultiples;
    }

    public function addQuestionChoixMultiple(QuestionChoixMultiples $questionChoixMultiple): self
    {
        if (!$this->questionChoixMultiples->contains($questionChoixMultiple)) {
            $this->questionChoixMultiples[] = $questionChoixMultiple;
            $questionChoixMultiple->setSondage($this);
        }

        return $this;
    }

    public function removeQuestionChoixMultiple(QuestionChoixMultiples $questionChoixMultiple): self
    {
        if ($this->questionChoixMultiples->removeElement($questionChoixMultiple)) {
            // set the owning side to null (unless already changed)
            if ($questionChoixMultiple->getSondage() === $this) {
                $questionChoixMultiple->setSondage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setSondage($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getSondage() === $this) {
                $question->setSondage(null);
            }
        }

        return $this;
    }

    public function getRemun(): ?string
    {
        return $this->remun;
    }

    public function setRemun(string $remun): self
    {
        $this->remun = $remun;

        return $this;
    }

    public function getMisEnLigne(): ?bool
    {
        return $this->misEnLigne;
    }

    public function setMisEnLigne(?bool $misEnLigne): self
    {
        $this->misEnLigne = $misEnLigne;

        return $this;
    }

    public function getCadeau(): ?Cadeau
    {
        return $this->cadeau;
    }

    public function setCadeau(?Cadeau $cadeau): self
    {
        $this->cadeau = $cadeau;

        return $this;
    }

    public function getRemise(): ?Remise
    {
        return $this->remise;
    }

    public function setRemise(?Remise $remise): self
    {
        $this->remise = $remise;

        return $this;
    }
    /**
     * @return Collection|SondageRepondu[]
     */
    public function getSondageRepondus(): Collection
    {
        return $this->sondageRepondus;
    }

    public function addSondageRepondu(SondageRepondu $sondageRepondu): self
    {
        if (!$this->sondageRepondus->contains($sondageRepondu)) {
            $this->sondageRepondus[] = $sondageRepondu;
            $sondageRepondu->setSondage($this);
        }

        return $this;
    }

    public function removeSondageRepondu(SondageRepondu $sondageRepondu): self
    {
        if ($this->sondageRepondus->removeElement($sondageRepondu)) {
            // set the owning side to null (unless already changed)
            if ($sondageRepondu->getSondage() === $this) {
                $sondageRepondu->setSondage(null);
            }
        }

        return $this;
    }
    public function getAdrRecup(): ?string
    {
        return $this->AdrRecup;
    }

    public function setAdrRecup(string $AdrRecup): self
    {
        $this->AdrRecup = $AdrRecup;

        return $this;
    }
}
