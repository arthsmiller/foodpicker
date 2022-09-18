<?php

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: Coupon::class)]
    protected Restaurant $restaurant;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected Carbon $receiveDate;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected Carbon $expirationDate;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $amount;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    protected bool $redeemed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant($restaurant): void
    {
        $this->restaurant = $restaurant;
    }

    public function getReceiveDate(): ?Carbon
    {
        return $this->receiveDate;
    }

    public function setReceiveDate($receiveDate): void
    {
        $this->receiveDate = $receiveDate;
    }

    public function getExpirationDate(): Carbon
    {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function getRedeemed(): ?bool
    {
        return $this->redeemed;
    }

    public function seRedeemed($redeemed): void
    {
        $this->redeemed = $redeemed;
    }
}