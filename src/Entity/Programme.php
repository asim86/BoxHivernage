<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeRepository")
 */
class Programme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $TriggerWaterTemperature;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StartTime1;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StopTime1;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StartTime2;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StopTime2;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StartTime3;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StopTime3;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StartTime4;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $StopTime4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getTriggerWaterTemperature(): ?float
    {
        return $this->TriggerWaterTemperature;
    }

    public function setTriggerWaterTemperature(?float $TriggerWaterTemperature): self
    {
        $this->TriggerWaterTemperature = $TriggerWaterTemperature;

        return $this;
    }

    public function getStartTime1(): ?\DateTimeInterface
    {
        return $this->StartTime1;
    }

    public function setStartTime1(?\DateTimeInterface $StartTime1): self
    {
        $this->StartTime1 = $StartTime1;

        return $this;
    }

    public function getStopTime1(): ?\DateTimeInterface
    {
        return $this->StopTime1;
    }

    public function setStopTime1(?\DateTimeInterface $StopTime1): self
    {
        $this->StopTime1 = $StopTime1;

        return $this;
    }

    public function getStartTime2(): ?\DateTimeInterface
    {
        return $this->StartTime2;
    }

    public function setStartTime2(?\DateTimeInterface $StartTime2): self
    {
        $this->StartTime2 = $StartTime2;

        return $this;
    }

    public function getStopTime2(): ?\DateTimeInterface
    {
        return $this->StopTime2;
    }

    public function setStopTime2(?\DateTimeInterface $StopTime2): self
    {
        $this->StopTime2 = $StopTime2;

        return $this;
    }

    public function getStartTime3(): ?\DateTimeInterface
    {
        return $this->StartTime3;
    }

    public function setStartTime3(?\DateTimeInterface $StartTime3): self
    {
        $this->StartTime3 = $StartTime3;

        return $this;
    }

    public function getStopTime3(): ?\DateTimeInterface
    {
        return $this->StopTime3;
    }

    public function setStopTime3(?\DateTimeInterface $StopTime3): self
    {
        $this->StopTime3 = $StopTime3;

        return $this;
    }

    public function getStartTime4(): ?\DateTimeInterface
    {
        return $this->StartTime4;
    }

    public function setStartTime4(?\DateTimeInterface $StartTime4): self
    {
        $this->StartTime4 = $StartTime4;

        return $this;
    }

    public function getStopTime4(): ?\DateTimeInterface
    {
        return $this->StopTime4;
    }

    public function setStopTime4(?\DateTimeInterface $StopTime4): self
    {
        $this->StopTime4 = $StopTime4;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
