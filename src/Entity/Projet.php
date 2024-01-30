<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use App\Enum\StatutTâche;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   
    #[ORM\Column(length: 255)]
    private ?StatutTâche $status = null ;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Tache::class)]
    private Collection $taches;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Echeance $echeance = null;

    #[ORM\ManyToMany(targetEntity: Collaborateur::class, inversedBy: 'projets')]
    private Collection $Collaborateurs;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?User $Users = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->Collaborateurs = new ArrayCollection();
        $this->createdAt = new  \DateTimeImmutable();
        $this->updatedAt = new  \DateTimeImmutable();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?StatutTâche
    {
        return $this->status;
    }

    public function setStatus(?StatutTâche $status): static
    {
        $this->status = $status;
    
        return $this;
    }
    

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }
 
    public function addTach(Tache $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setProjet($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getProjet() === $this) {
                $tach->setProjet(null);
            }
        }

        return $this;
    }

    public function getEcheance(): ?Echeance
    {
        return $this->echeance;
    }

    public function setEcheance(?Echeance $echeance): static
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * @return Collection<int, Collaborateur>
     */
    public function getCollaborateurs(): Collection
    {
        return $this->Collaborateurs;
    }

    public function addCollaborateur(Collaborateur $collaborateur): static
    {
        if (!$this->Collaborateurs->contains($collaborateur)) {
            $this->Collaborateurs->add($collaborateur);
        }

        return $this;
    }

    public function removeCollaborateur(Collaborateur $collaborateur): static
    {
        $this->Collaborateurs->removeElement($collaborateur);

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->Users;
    }

    public function setUsers(?User $Users): static
    {
        $this->Users = $Users;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

  
}
