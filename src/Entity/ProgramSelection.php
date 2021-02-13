<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramSelectionRepository")
 */
class ProgramSelection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $selectionDate;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Programme")
     */
    private $program;

    /**
     * @ORM\OneToOne (targetEntity="App\Entity\Piscine")
     */
    private $piscine;

    /**
     * @ORM\Column(type="boolean")
     */
    private $forced;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $forceUntil;

    /**
     * @ORM\Column (type="boolean")
     */
    private $forcedStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSelectionDate(): ?\DateTimeInterface
    {
        return $this->selectionDate;
    }

    public function setSelectionDate(\DateTimeInterface $selectionDate): self
    {
        $this->selectionDate = $selectionDate;

        return $this;
    }

    public function getForced(): ?bool
    {
        return $this->forced;
    }

    public function setForced(bool $forced): self
    {
        $this->forced = $forced;

        return $this;
    }

    public function getForceUntil(): ?\DateTimeInterface
    {
        return $this->forceUntil;
    }

    public function setForceUntil(?\DateTimeInterface $forceUntil): self
    {
        $this->forceUntil = $forceUntil;

        return $this;
    }

    public function getProgram(): ?Programme
    {
        return $this->program;
    }

    public function setProgram(?Programme $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getPiscine(): ?Piscine
    {
        return $this->piscine;
    }

    public function setPiscine(?Piscine $piscine): self
    {
        $this->piscine = $piscine;

        return $this;
    }

    public function getForcedStatus(): ?bool
    {
        return $this->forcedStatus;
    }

    public function setForcedStatus(bool $forcedStatus): self
    {
        $this->forcedStatus = $forcedStatus;

        return $this;
    }
}
