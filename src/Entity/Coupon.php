<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected $id;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: Coupon::class)]
    protected $restaurant;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected $receiveDate;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected $expirationDate;

    #[ORM\Column(type: Types::INTEGER)]
    protected $amount;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected $stillValid;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getRestaurant()
    {
        return $this->restaurant;
    }

    public function setRestaurant($restaurant): void
    {
        $this->restaurant = $restaurant;
    }

    public function getReceiveDate()
    {
        return $this->receiveDate;
    }

    public function setReceiveDate($receiveDate): void
    {
        $this->receiveDate = $receiveDate;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function getStillValid()
    {
        return $this->stillValid;
    }

    public function setStillValid($stillValid): void
    {
        $this->stillValid = $stillValid;
    }
}