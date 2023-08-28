<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use App\Validator\Constraints\OrderConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[OrderConstraint]
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
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $sum = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $productsAmount = null;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "orders")]
    private ?User $user;

    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $products;

    /**
     * Order constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return string|null
     */
    public function getProductsAmount(): ?string
    {
        return $this->productsAmount;
    }

    /**
     * @param string $productsAmount
     * @return $this
     */
    public function setProductsAmount(string $productsAmount): self
    {
        $this->productsAmount = $productsAmount;

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
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"             => $this->getId(),
            "user"           => $this->getUser(),
            "products"       => $this->getProducts()->getValues(),
            "productsAmount" => $this->getProductsAmount(),
            "sum"            => $this->getSum(),
        ];
    }
}
