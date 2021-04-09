<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaylistRepository::class)
 */
class Playlist
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
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="playlists")
     */
    private $id_user;

    /**
     * @ORM\ManyToMany(targetEntity=Musics::class, inversedBy="playlists")
     */
    private $musics;

    public function __construct()
    {
        $this->id_user = new ArrayCollection();
        $this->musics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }

    /**
     * @return Collection|Musics[]
     */
    public function getMusics(): Collection
    {
        return $this->musics;
    }

    public function addMusic(Musics $music): self
    {
        if (!$this->musics->contains($music)) {
            $this->musics[] = $music;
        }

        return $this;
    }

    public function removeMusic(Musics $music): self
    {
        $this->musics->removeElement($music);

        return $this;
    }
}
