<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Measurable
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $count;

    /**
     * @var Unit
     * @ORM\ManyToOne (targetEntity="Unit")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    protected $unit;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return Measurable
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return Unit
     */
    public function getUnit(): Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit $unit
     *
     * @return Measurable
     */
    public function setUnit(Unit $unit): Measurable
    {
        $this->unit = $unit;

        return $this;
    }
}
