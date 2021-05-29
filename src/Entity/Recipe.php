<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe implements \JsonSerializable
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToMany(targetEntity="RecipeTool")
     * @ORM\JoinTable(name="recpie_tools",
     *      joinColumns={@ORM\JoinColumn(name="recpie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tool_id", referencedColumnName="id")}
     *      )
     * @var RecipeTool[]
     */
    private $tools;

    /**
     * @ORM\ManyToMany(targetEntity="RecipeIngredient")
     * @ORM\JoinTable(name="recpie_ingredients",
     *      joinColumns={@ORM\JoinColumn(name="recpie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     * @var RecipeIngredient[]
     */
    private $ingredients;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @var int
     * @ORM\Column(type="time")
     */
    private $created;

    /**
     * @var int
     * @ORM\Column(type="time")
     */
    private $updated;

    public function __construct()
    {
        $this->tools = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->created = time();
        $this->updated = time();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return Recipe
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return RecipeTool[]
     */
    public function getTools(): array
    {
        return $this->tools;
    }

    /**
     * @param RecipeTool[] $tools
     *
     * @return Recipe
     */
    public function setTools(array $tools): self
    {
        $this->tools = $tools;

        return $this;
    }

    /**
     * @return RecipeIngredient[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @param RecipeIngredient[] $ingredients
     *
     * @return Recipe
     */
    public function setIngredients(array $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     *
     * @return Recipe
     */
    public function setCreator(User $creator): Recipe
    {
        $this->creator = $creator;

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

    public function addTool(RecipeTool $tool): self
    {
        if (!$this->tools->contains($tool)) {
            $this->tools[] = $tool;
        }

        return $this;
    }

    public function removeTool(RecipeTool $tool): self
    {
        $this->tools->removeElement($tool);

        return $this;
    }

    public function addIngredient(RecipeIngredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(RecipeIngredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [];
    }
}
