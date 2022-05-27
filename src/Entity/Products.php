<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductsRepository;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_product",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[Serializer\ExclusionPolicy("ALL")]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Cet champs est obligatoire")]
    #[Serializer\Expose()]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message:"Cet champs est obligatoire")]
    #[Assert\Length(min:20, max:2000, minMessage:"La description doit faire minimum {{ limit }} caractères", maxMessage:"La description doit faire maximum {{ limit }} caratères")]
    #[Serializer\Expose()]
    private $description;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message:"Cet champs est obligatoire")]
    #[Assert\PositiveOrZero(message:"Le prix doit être positif")]
    #[Serializer\Expose()]
    private $price;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message:"Le stock est obligatoire")]
    #[Assert\PositiveOrZero(message:"Le stock doit être positif ou égal a zéro")]
    private $stock;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\DateTime(message:"Renseignez une date de création valide")]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Assert\DateTime(message:"Renseignez une date de modification valide")]
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
