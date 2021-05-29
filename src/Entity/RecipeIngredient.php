<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RecipeIngredientRepository::class)
 */
class RecipeIngredient extends Measurable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $ingredient;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $creator_id;

    /**
     * @ORM\Column(type="time")
     * @var int
     */
    private $created;

    /**
     * @ORM\Column(type="time")
     * @var int
     */
    private $updated;

    public function __construct()
    {
        $this->created = time();
        $this->updated = time();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatorId(): int
    {
        return $this->creator_id;
    }

    /**
     * @param int $creator_id
     *
     * @return RecipeIngredient
     */
    public function setCreatorId(int $creator_id): RecipeIngredient
    {
        $this->creator_id = $creator_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
