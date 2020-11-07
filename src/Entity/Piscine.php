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
     * @ORM\OneToMany(targetEntity="App\Entity\CloudLink", mappedBy="piscine")
     */
    private $cloudLink;

    /**
     * @ORM\Column(name="api_key", type="string", length=191, nullable=false, unique=true)
     */
    private $apiKey;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $typeChimie;

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

    public function addCloudLink(CloudLink $cloudLink): self
    {
        if (!$this->cloudLink->contains($cloudLink)) {
            $this->cloudLink[] = $cloudLink;
            $cloudLink->setPiscine($this);
        }

        return $this;
    }

    public function removeCloudLink(CloudLink $cloudLink): self
    {
        if ($this->cloudLink->contains($cloudLink)) {
            $this->cloudLink->removeElement($cloudLink);
            // set the owning side to null (unless already changed)
            if ($cloudLink->getPiscine() === $this) {
                $cloudLink->setPiscine(null);
            }
        }

        return $this;
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
}
