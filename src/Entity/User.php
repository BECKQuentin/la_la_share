<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**     
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image = 'default/default_avatar.png';

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $verifiedEmail;

    /**
     * @ORM\OneToMany(targetEntity=FriendsRequest::class, mappedBy="sender")
     */
    private $sentFriendsRequests;

    /**
     * @ORM\OneToMany(targetEntity=FriendsRequest::class, mappedBy="receiver")
     */
    private $receivedFriendsRequests;

    /**
     * @ORM\ManyToMany(targetEntity=Playlist::class, mappedBy="id_user")
     */
    private $playlists;
   

    public function __construct()
    {
        $this->sentFriendsRequests = new ArrayCollection();
        $this->receivedFriendsRequests = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function isFriendsWith(User $user): bool
    {
        foreach ($this->getFriendsRequests() as $friendRequest) {
            if( ($this === $friendRequest->getSender() && $user === $friendRequest->getReceiver()
            || $this === $friendRequest->getReceiver() && $user === $friendRequest->getSender())
            && $friendRequest->isAccepted() ) {
                return true;
            }
        }
        return false;
    }
    
    public function isRequestPending(User $user): bool
    {
        foreach ($this->getFriendsRequests() as $friendRequest) {
            if( ($this === $friendRequest->getSender() && $user === $friendRequest->getReceiver())
            && $friendRequest->isAccepted() === false) {
                return true;
            }
        }
        return false;
    }

    public function isRequestReceiving(User $user): bool
    {
        foreach ($this->getFriendsRequests() as $friendRequest) {
            if( ($this === $friendRequest->getReceiver() && $user === $friendRequest->getSender())
            && $friendRequest->isAccepted() === false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @return Collection|FriendsRequest[]
     */
    public function getFriendsRequests(): Collection
    {
        $friendRequest = new ArrayCollection();
        foreach ($this->getSentFriendsRequests() as $fr) {
            $friendRequest->add($fr);
        }
        foreach ($this->getReceivedFriendsRequests() as $fr) {
            $friendRequest->add($fr);
        }
        return $friendRequest;
    }

    /**
     * @return Collection|FriendsRequest[]
     */
    public function getReceivedFriendsRequestsPending(): Collection
    {
        return $this->getReceivedFriendsRequests()->filter(function(FriendsRequest $friendRequest) {
            return $friendRequest->getAccepted() == false;
        });
    }
        
    public function getFullname()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getImageDirectory(): string
    {
        return 'avatar';
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVerifiedEmail(): ?bool
    {
        return $this->verifiedEmail;
    }

    public function setVerifiedEmail(bool $verifiedEmail): self
    {
        $this->verifiedEmail = $verifiedEmail;

        return $this;
    }

    /**
     * @return Collection|FriendsRequest[]
     */
    public function getSentFriendsRequests(): Collection
    {
        return $this->sentFriendsRequests;
    }

    public function addSentFriendsRequest(FriendsRequest $sentFriendsRequest): self
    {
        if (!$this->sentFriendsRequests->contains($sentFriendsRequest)) {
            $this->sentFriendsRequests[] = $sentFriendsRequest;
            $sentFriendsRequest->setSender($this);
        }

        return $this;
    }

    public function removeSentFriendsRequest(FriendsRequest $sentFriendsRequest): self
    {
        if ($this->sentFriendsRequests->removeElement($sentFriendsRequest)) {
            // set the owning side to null (unless already changed)
            if ($sentFriendsRequest->getSender() === $this) {
                $sentFriendsRequest->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FriendsRequest[]
     */
    public function getReceivedFriendsRequests(): Collection
    {
        return $this->receivedFriendsRequests;
    }

    public function addReceivedFriendsRequest(FriendsRequest $receivedFriendsRequest): self
    {
        if (!$this->receivedFriendsRequests->contains($receivedFriendsRequest)) {
            $this->receivedFriendsRequests[] = $receivedFriendsRequest;
            $receivedFriendsRequest->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedFriendsRequest(FriendsRequest $receivedFriendsRequest): self
    {
        if ($this->receivedFriendsRequests->removeElement($receivedFriendsRequest)) {
            // set the owning side to null (unless already changed)
            if ($receivedFriendsRequest->getReceiver() === $this) {
                $receivedFriendsRequest->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Playlist[]
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): self
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists[] = $playlist;
            $playlist->addIdUser($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): self
    {
        if ($this->playlists->removeElement($playlist)) {
            $playlist->removeIdUser($this);
        }

        return $this;
    }
  
}
