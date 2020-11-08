<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PiscineRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Piscine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $longueur;

    /**
     * @ORM\Column(type="float")
     */
    private $largeur;

    /**
     * @ORM\Column(type="float")
     */
    private $profondeur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $forme;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $filtration;

    /**
     * @ORM\Column(name="api_key", type="string", length=191, nullable=false, unique=true)
     */
    private $apiKey;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $typeChimie;

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
     * @ORM\Column (type="boolean")
     */
    private $pumpStatus;

    /**
     * @ORM\Column (type="datetime", nullable=true)
     */
    private $nextPumpStatusSwitch;

    /**
     * @ORM\PrePersist()
     */
    public function firstSave()
    {
        $this->setApiKey(
            implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6))
        );
    }

    public function __construct()
    {
        $this->cloudLink = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getProfondeur(): ?float
    {
        return $this->profondeur;
    }

    public function setProfondeur(float $profondeur): self
    {
        $this->profondeur = $profondeur;

        return $this;
    }

    public function getForme(): ?string
    {
        return $this->forme;
    }

    public function setForme(string $forme): self
    {
        $this->forme = $forme;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getFiltration(): ?string
    {
        return $this->filtration;
    }

    public function setFiltration(?string $filtration): self
    {
        $this->filtration = $filtration;

        return $this;
    }

    public function getTypeChimie(): ?string
    {
        return $this->typeChimie;
    }

    public function setTypeChimie(?string $typeChimie): self
    {
        $this->typeChimie = $typeChimie;

        return $this;
    }

    /**
     * @return Collection|CloudLink[]
     */
    public function getCloudLink(): Collection
    {
        return $this->cloudLink;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
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

    public function getPumpStatus(): ?bool
    {
        return $this->pumpStatus;
    }

    public function setPumpStatus(bool $pumpStatus): self
    {
        $this->pumpStatus = $pumpStatus;

        return $this;
    }

    public function getNextPumpStatusSwitch(): ?\DateTimeInterface
    {
        return $this->nextPumpStatusSwitch;
    }

    public function setNextPumpStatusSwitch(?\DateTimeInterface $nextPumpStatusSwitch): self
    {
        $this->nextPumpStatusSwitch = $nextPumpStatusSwitch;

        return $this;
    }
}
