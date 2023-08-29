<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use App\Validator\Constraints\CategoryConstraint;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[CategoryConstraint]
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
class Category implements JsonSerializable
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
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $type = null;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"   => $this->getId(),
            "name" => $this->getName(),
            "type" => $this->getType()
        ];
    }
}
