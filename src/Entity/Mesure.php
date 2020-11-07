<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MesureRepository")
 */
class Mesure
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
    private $date;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $temperature;

    /**
     * @ORM\Column(name="ph", type="string", length=191, nullable=true)
     */
    private $pH;

    /**
     * @ORM\Column(name="raw_ph", type="string", length=191, nullable=true)
     */
    private $rawPH;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Piscine")
     */
    private $piscine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getPH(): ?string
    {
        return $this->pH;
    }

    public function setPH(?string $pH): self
    {
        $this->pH = $pH;

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

    public function getRawPH(): ?string
    {
        return $this->rawPH;
    }

    public function setRawPH(?string $rawPH): self
    {
        $this->rawPH = $rawPH;

        return $this;
    }
}
