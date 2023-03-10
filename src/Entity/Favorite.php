<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favorites')]
    private Collection $user;

    #[ORM\ManyToMany(targetEntity: Music::class, inversedBy: 'favorites')]
    private Collection $music;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->music = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}