<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToOne(mappedBy: 'category', targetEntity: Product::class, cascade: ['persist', 'remove'])]
    private $products;

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

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        // unset the owning side of the relation if necessary
        if ($products === null && $this->products !== null) {
            $this->products->setCategory(null);
        }

        // set the owning side of the relation if necessary
        if ($products !== null && $products->getCategory() !== $this) {
            $products->setCategory($this);
        }

        $this->products = $products;

        return $this;
    }
}
