<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OperationRepository::class)]
#[Vich\Uploadable]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'zipFile', fileNameProperty: 'global_zip', size: 'zipSize')]
    #[Assert\File(
        maxSize: '1024M',
        mimeTypes: ['application/zip', 'application/pdf'],
        mimeTypesMessage: 'Veuillez télécharger un fichier de type ZIP ou PDF'
    )]
    private ?File $zipFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $global_zip = null;

    #[ORM\Column(nullable: true)]
    private ?int $zipSize = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'operation_visuel', fileNameProperty: 'visuel', size: 'imageSize')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Veuillez télécharger un fichier image valide (jpg, png)'
    )]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $visuel = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $uploadTimestamp = null;

    #[ORM\OneToMany(mappedBy: 'operation', targetEntity: Outil::class, cascade: ['persist','remove'])]
    private Collection $outils;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToMany(targetEntity: Marque::class, inversedBy: 'operations')]
    private Collection $marques;

    #[ORM\Column]
    private ?bool $alaune = null;

    #[ORM\OneToMany(mappedBy: 'outil', targetEntity: StatUser::class, cascade: ['remove'])]
    private Collection $statUsers;



    public function __construct()
    {
        $this->outils = new ArrayCollection();
        $this->marques = new ArrayCollection();
        $this->statUsers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }




    /**
     * @return Collection<int, Outil>
     */
    public function getOutils(): Collection
    {
        return $this->outils;
    }

    public function addOutil(Outil $outil): self
    {
        if (!$this->outils->contains($outil)) {
            $this->outils->add($outil);
            $outil->setOperation($this);
        }

        return $this;
    }

    public function removeOutil(Outil $outil): self
    {
        if ($this->outils->removeElement($outil)) {
            // set the owning side to null (unless already changed)
            if ($outil->getOperation() === $this) {
                $outil->setOperation(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function setVisuel(?string $visuel): self
    {
        $this->visuel = $visuel;
        return $this;
    }
    public function getVisuel(): ?string
    {
        return $this->visuel;
    }




    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function __toString(): string
    {
        return $this->titre;
    }

    /**
     * @return Collection<int, Marque>
     */
    public function getMarques(): Collection
    {
        return $this->marques;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques->add($marque);
            $marque->addOperation($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->removeElement($marque)) {
            $marque->removeOperation($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }


   public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }



    public function setZipFile(?File $zipFile = null): void
    {
        $this->zipFile = $zipFile;

        if (null !== $zipFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->uploadTimestamp = new \DateTimeImmutable();
        }
    }

    public function getZipFile(): ?File
    {
        return $this->zipFile;
    }



    public function getGlobalZip(): ?string
    {
        return $this->global_zip;
    }

    public function setGlobalZip(?string $global_zip): self
    {
        $this->global_zip = $global_zip;
        return $this;
    }


    public function getUploadTimestamp(): \DateTimeInterface
    {
        return $this->uploadTimestamp;
    }


    public function setZipSize(?int $zipSize): void
    {
        $this->zipSize = $zipSize;
    }

    public function getZipSize(): ?int
    {
        return $this->zipSize;
    }

    public function isAlaune(): ?bool
    {
        return $this->alaune;
    }

    public function setAlaune(bool $alaune): self
    {
        $this->alaune = $alaune;

        return $this;
    }

    /**
     * @return Collection<int, StatUser>
     */
    public function getStatUsers(): Collection
    {
        return $this->statUsers;
    }

    public function addStatUser(StatUser $statUser): self
    {
        if (!$this->statUsers->contains($statUser)) {
            $this->statUsers->add($statUser);
            $statUser->setOperation($this);
        }

        return $this;
    }

    public function removeStatUser(StatUser $statUser): self
    {
        if ($this->statUsers->removeElement($statUser)) {
            // set the owning side to null (unless already changed)
            if ($statUser->getOperation() === $this) {
                $statUser->setOperation(null);
            }
        }

        return $this;
    }





}
