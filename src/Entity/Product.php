<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable:false)]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;    

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gift = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $warranty = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
    
    public function __toString()
    {
        return (string)$this->getId();
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

    

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        if ($image != null) {
            $this->image = $image;
        }
        return $this;
    }


    public function getGift(): ?string
    {
        return $this->gift;
    }

    public function setGift(?string $gift): self
    {
        $this->gift = $gift;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getWarranty(): ?string
    {
        return $this->warranty;
    }

    public function setWarranty(string $warranty): self
    {
        $this->warranty = $warranty;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
