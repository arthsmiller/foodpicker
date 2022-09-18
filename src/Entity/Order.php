<?php

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: Restaurant::class, inversedBy: Order::class)]
    protected Restaurant $restaurant;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: Order::class)]
    protected User $commiter;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected Carbon $orderTime;

    #[ORM\Column(type: 'datetime', options: ['secondPrecision' => true], nullable: true)]
    protected Carbon $deliveryTime;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $totalPersons;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $totalPrice;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $totalItems;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $faulty;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $bonus;

    public function getId()
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

    public function getCommiter(): ?Commiter
    {
        return $this->commiter;
    }

    public function setCommiter($commiter): void
    {
        $this->commiter = $commiter;
    }

    public function getOrderTime(): ?Carbon
    {
        return $this->orderTime;
    }

    public function setOrderTime($orderTime): void
    {
        $this->orderTime = $orderTime;
    }

    public function getDeliveryTime(): ?Carbon
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime($deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function getTotalPersons(): ?int
    {
        return $this->totalPersons;
    }

    public function setTotalPersons($totalPersons): void
    {
        $this->totalPersons = $totalPersons;
    }

    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }

    public function setTotalItems($totalItems): void
    {
        $this->totalItems = $totalItems;
    }

    public function getFaulty(): ?bool
    {
        return $this->faulty;
    }

    public function setFaulty($faulty): void
    {
        $this->faulty = $faulty;
    }

    public function getBonus(): ?bool
    {
        return $this->bonus;
    }

    public function setBonus($bonus): void
    {
        $this->bonus = $bonus;
    }

}