<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MusicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MusicRepository::class)]
class Music
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("music:read")]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("music:read")]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    #[Groups("music:read")]
    private ?string $Singer = null;

    #[ORM\ManyToOne(inversedBy: 'musics')]
    #[ORM\JoinColumn(nullable: false)]

    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    #[Groups("music:read")]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups("music:read")]
    private ?string $sound = null;

    #[ORM\ManyToMany(targetEntity: Favorite::class, mappedBy: 'music')]
    private Collection $favorites;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoris')]
    private Collection $favoris;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSinger(): ?string
    {
        return $this->Singer;
    }

    public function setSinger(string $Singer): self
    {
        $this->Singer = $Singer;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    public function getSound(): ?string
    {
        return $this->sound;
    }

    public function setSound(string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(User $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }


    /**
     * Get the URL of the music.
     *
     * @return string The URL of the music.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}