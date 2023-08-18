<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: "users")]
    private ?Role $role = null;
    #[ORM\OneToMany(mappedBy: "users", targetEntity: Book::class)]
    private Collection $books;
    #[ORM\OneToMany(mappedBy: "likes", targetEntity: Like::class)]
    private Collection $likes;
    #[ORM\OneToMany(mappedBy: "users", targetEntity: Comment::class)]
    private Collection $comments;


    /**
     * Comment Constructor
     * Book Constructor
     * Like Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * @param Collection $likes
     * @return $this
     */
    public function setLikes(Collection $likes): self
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    /**
     * @param Collection $books
     * @return $this
     */
    public function setBooks(Collection $books): self
    {
        $this->books = $books;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Collection $comments
     * @return $this
     */
    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param Role|null $role
     * @return $this
     */
    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @param string|null $about
     * @return $this
     */
    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return $this
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "login" => $this->getLogin(),
            "password" => $this->getPassword(),
            "about" => $this->getAbout(),
            "role" => $this->getRole()
        ];
    }
}
