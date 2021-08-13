<?php

namespace App\Entity;

use App\Repository\ActionTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionTypeRepository::class)
 */
class ActionType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $ActionTypeName;

    public function __toString()
    {
        return $this->ActionTypeName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionTypeName(): ?string
    {
        return $this->ActionTypeName;
    }

    public function setActionTypeName(string $ActionTypeName): self
    {
        $this->ActionTypeName = $ActionTypeName;

        return $this;
    }
}
