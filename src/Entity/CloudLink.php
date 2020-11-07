<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CloudLinkRepository")
 */
class CloudLink
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $linkType;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $cloudKey;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $cloudServer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Piscine", inversedBy="cloudLink")
     */
    private $piscine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkType(): ?string
    {
        return $this->linkType;
    }

    public function setLinkType(string $linkType): self
    {
        $this->linkType = $linkType;

        return $this;
    }

    public function getCloudKey(): ?string
    {
        return $this->cloudKey;
    }

    public function setCloudKey(string $cloudKey): self
    {
        $this->cloudKey = $cloudKey;

        return $this;
    }

    public function getCloudServer(): ?string
    {
        return $this->cloudServer;
    }

    public function setCloudServer(string $cloudServer): self
    {
        $this->cloudServer = $cloudServer;

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

    public function __toString()
    {
        return $this->getLinkType();
    }
}
