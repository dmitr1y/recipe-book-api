<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecipeToolRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RecipeToolRepository::class)
 */
class RecipeTool extends Measurable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tool::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $tool;

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

    public function getTool(): ?Tool
    {
        return $this->tool;
    }

    public function setTool(?Tool $tool): self
    {
        $this->tool = $tool;

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
     * @return RecipeTool
     */
    public function setCreatorId(int $creator_id): RecipeTool
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
}
