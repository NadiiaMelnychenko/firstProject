<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order implements JsonSerializable
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $sum = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $time = null;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "orders")]
    private ?User $user = null;

//    /**
//     * @var Book|null
//     */
//    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: "orders")]
//    private ?Book $book = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $books = null;

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
    public function getBooks(): ?string
    {
        return $this->books;
    }

    /**
     * @param string|null $books
     * @return $this
     */
    public function setBooks(?string $books): self
    {
        $this->books = $books;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSum(): ?string
    {
        return $this->sum;
    }

    /**
     * @param string $sum
     * @return $this
     */
    public function setSum(string $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @param DateTimeInterface $time
     * @return $this
     */
    public function setTime(DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"    => $this->getId(),
            "books" => $this->getBooks(),
            "sum"  => $this->getSum(),
            "time" => $this->getTime()->format('Y-m-d H:i'),
            "user"  => $this->getUser()
        ];
    }
}
