<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity]
class Test implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $test = null;


    /**
     * @return string|null
     */
    public function getTest(): ?string
    {
        return $this->test;
    }

    /**
     * @param string|null $test
     * @return void
     */
    public function setTest(?string $test): void
    {
        $this->test = $test;
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
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param string|null $info
     * @return $this
     */
    public function setInfo(?string $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "info" => $this->getInfo()
        ];
    }
}
