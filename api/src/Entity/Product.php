<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use App\Validator\Constraints\ProductConstraint;
use Symfony\Component\Validator\Constraints\Positive;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ProductConstraint]
#[ApiResource(
    collectionOperations: [
        "get"  => [
            "method" => "GET",
        ],
        "post" => [
            "method"   => "POST",
            "security" => "is_granted('" . User::ROLE_ADMIN . "')"
        ]
    ],
    itemOperations: [
        "get"    => [
            "method" => "GET"
        ],
        "put"    => [
            "method"   => "PUT",
            "security" => "is_granted('" . User::ROLE_ADMIN . "')"
        ],
        "delete" => [
            "method"   => "DELETE",
            "security" => "is_granted('" . User::ROLE_ADMIN . "')"
        ],
        "patch"  => [
            "method"   => "PATCH",
            "security" => "is_granted('" . User::ROLE_ADMIN . "')"
        ]
    ],
//    attributes: [
//        "security" => "is_granted('" . User::ROLE_USER . "')"
//    ]
)
]
class Product implements JsonSerializable
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
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[NotNull]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: '0')]
    #[Positive]
    #[NotNull]
    private ?string $price = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

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
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"          => $this->getId(),
            "name"        => $this->getName(),
            "price"       => $this->getPrice(),
            "description" => $this->getDescription(),
        ];
    }
}
