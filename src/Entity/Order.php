<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected $id;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: Order::class)]
    protected $restaurant;

    #[ORM\ManyToOne(targetEntity: Commiter::class, inversedBy: Order::class)]
    protected $commiter;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected $orderTime;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected $deliveryTime;

    #[ORM\Column(type: Types::INTEGER)]
    protected $totalPersons;

    #[ORM\Column(type: Types::INTEGER)]
    protected $totalPrice;

    #[ORM\Column(type: Types::INTEGER)]
    protected $totalItems;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected $faulty;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected $bonus;

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

    public function getCommiter()
    {
        return $this->commiter;
    }

    public function setCommiter($commiter): void
    {
        $this->commiter = $commiter;
    }

    public function getOrderTime()
    {
        return $this->orderTime;
    }

    public function setOrderTime($orderTime): void
    {
        $this->orderTime = $orderTime;
    }

    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime($deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getTotalPersons()
    {
        return $this->totalPersons;
    }

    public function setTotalPersons($totalPersons): void
    {
        $this->totalPersons = $totalPersons;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }

    public function setTotalItems($totalItems): void
    {
        $this->totalItems = $totalItems;
    }

    public function getFaulty()
    {
        return $this->faulty;
    }

    public function setFaulty($faulty): void
    {
        $this->faulty = $faulty;
    }

    public function getBonus()
    {
        return $this->bonus;
    }

    public function setBonus($bonus): void
    {
        $this->bonus = $bonus;
    }

}