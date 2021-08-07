<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Weather
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $temperature;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $feelTemperature;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $temperature_min;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $temperature_max;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $pression;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $humidity;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $windSpeed;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $windDirection;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $weatherMain;

    /**
     * @ORM\Column (type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $WeatherDesc;

    public function __toString() {
        return $this->getTemperature();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFeelTemperature(): ?string
    {
        return $this->feelTemperature;
    }

    public function setFeelTemperature(?string $feelTemperature): self
    {
        $this->feelTemperature = $feelTemperature;

        return $this;
    }

    public function getTemperatureMin(): ?string
    {
        return $this->temperature_min;
    }

    public function setTemperatureMin(?string $temperature_min): self
    {
        $this->temperature_min = $temperature_min;

        return $this;
    }

    public function getTemperatureMax(): ?string
    {
        return $this->temperature_max;
    }

    public function setTemperatureMax(?string $temperature_max): self
    {
        $this->temperature_max = $temperature_max;

        return $this;
    }

    public function getPression(): ?string
    {
        return $this->pression;
    }

    public function setPression(?string $pression): self
    {
        $this->pression = $pression;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(?string $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getWindSpeed(): ?string
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(?string $windSpeed): self
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->windDirection;
    }

    public function setWindDirection(?string $windDirection): self
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    public function getWeatherMain(): ?string
    {
        return $this->weatherMain;
    }

    public function setWeatherMain(?string $weatherMain): self
    {
        $this->weatherMain = $weatherMain;

        return $this;
    }

    public function getWeatherDesc(): ?string
    {
        return $this->WeatherDesc;
    }

    public function setWeatherDesc(?string $WeatherDesc): self
    {
        $this->WeatherDesc = $WeatherDesc;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function saveLastChange()
    {
        $this->setUpdatedAt(new DateTime('now'));
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
