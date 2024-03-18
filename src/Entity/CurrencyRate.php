<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CurrencyRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRateRepository::class)
 */
class CurrencyRate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $bankName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $currency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $currencyBase;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $rateSell;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $rateBuy;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private \DateTime $created;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankName(): string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): self
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrencyBase(): ?string
    {
        return $this->currencyBase;
    }

    public function setCurrencyBase(string $currencyBase): self
    {
        $this->currencyBase = $currencyBase;

        return $this;
    }

    public function getRateSell(): ?string
    {
        return $this->rateSell;
    }

    public function setRateSell(string $rateSell): self
    {
        $this->rateSell = $rateSell;

        return $this;
    }

    public function getRateBuy(): ?string
    {
        return $this->rateBuy;
    }

    public function setRateBuy(string $rateBuy): self
    {
        $this->rateBuy = $rateBuy;

        return $this;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }
}
