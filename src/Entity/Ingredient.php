<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IngredientRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\DateTime()
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created;

    /**
     * @Assert\DateTime()
     * @ORM\Column(type="datetime")
     * @var DateTime
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created->getTimestamp();
    }

    /**
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated->getTimestamp();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated(): void
    {
        //todo не перезаписывать поле
        $this->created = new \DateTime();;
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpdated(): void
    {
        $this->updated = new \DateTime();;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created' => $this->created->getTimestamp(),
        ];
    }
}
