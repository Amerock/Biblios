<?php
namespace App\Entity;

use App\Enum\StatusLivre;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[Assert\Isbn(type: 'isbn13')]
    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[Assert\NotBlank()]
    #[Assert\Url()]
    #[ORM\Column(length: 255)]
    private ?string $couverture = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $DateEdition = null;

    #[Assert\Length(min: 20)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $resume = null;

    #[Assert\Type(type: 'integer')]
    #[ORM\Column]
    private ?int $nbpages = null;

    #[ORM\Column(length: 255)]
    private ?StatusLivre $status = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editeur $editeur = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaire;

    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'livres')]
    private Collection $auteur;

    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
        $this->auteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;
        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(string $couverture): static
    {
        $this->couverture = $couverture;
        return $this;
    }

    public function getDateEdition(): ?\DateTimeImmutable
    {
        return $this->DateEdition;
    }

    public function setDateEdition(\DateTimeImmutable $DateEdition): static
    {
        $this->DateEdition = $DateEdition;
        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;
        return $this;
    }

    public function getNbpages(): ?int
    {
        return $this->nbpages;
    }

    public function setNbpages(int $nbpages): static
    {
        $this->nbpages = $nbpages;
        return $this;
    }

    public function getStatus(): ?StatusLivre
    {
        return $this->status;
    }

    public function setStatus(StatusLivre $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): static
    {
        $this->editeur = $editeur;
        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setLivre($this);
        }
        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaire->removeElement($commentaire)) {
            if ($commentaire->getLivre() === $this) {
                $commentaire->setLivre(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur->add($auteur);
        }
        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        $this->auteur->removeElement($auteur);
        return $this;
    }
}
