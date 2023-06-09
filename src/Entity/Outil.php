<?php

namespace App\Entity;

use App\Repository\OutilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OutilRepository::class)]
#[Vich\Uploadable]
class Outil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $visuel = null;

    #[ORM\ManyToOne(inversedBy: 'outils')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Operation $operation = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'outil_visuel', fileNameProperty: 'visuel', size: 'imageSize')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Veuillez télécharger un fichier image valide (jpg, png)'
    )]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'outil', targetEntity: StatUser::class)]
    private Collection $statUsers;

    public function __construct()
    {
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }



    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

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
            $statUser->setOutil($this);
        }

        return $this;
    }

    public function removeStatUser(StatUser $statUser): self
    {
        if ($this->statUsers->removeElement($statUser)) {
            // set the owning side to null (unless already changed)
            if ($statUser->getOutil() === $this) {
                $statUser->setOutil(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->titre;
    }
}
