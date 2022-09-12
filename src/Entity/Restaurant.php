<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity]
#[ORM\Table(name: 'restaurants')]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected $id;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: Restaurant::class)]
    protected ?Collection $orders;

    #[ORM\OneToMany(targetEntity: Coupon::class, mappedBy: Restaurant::class)]
    protected ?Collection $coupons;

    #[ORM\Column(type: Types::STRING)]
    protected $name;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    protected $categories;

    #[ORM\Column(type: Types::STRING)]
    protected $shopUrl;

    #[ORM\Column]
    protected $logoFile;

    #[ORM\Column(type: Types::STRING)]
    protected $logoUrl;

    #[ORM\Column(nullable: true)]
    protected $backgroundFile;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected $backgroundUrl;

    #[ORM\Column(type: Types::INTEGER)]
    protected $score = 0;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getOrders(): ?Collection
    {
        return $this->orders;
    }

    public function setOrders(?Collection $orders): void
    {
        $this->orders = $orders;
    }

    public function getCoupons(): ?Collection
    {
        return $this->coupons;
    }

    public function setCoupons(?Collection $coupons): void
    {
        $this->coupons = $coupons;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

    public function getShopUrl()
    {
        return $this->shopUrl;
    }

    public function setShopUrl($shopUrl): void
    {
        $this->shopUrl = $shopUrl;
    }

    public function getLogoFile()
    {
        return $this->logoFile;
    }

    public function setLogoFile($logoFile): void
    {
        $this->logoFile = $logoFile;
    }

    public function getBackgroundFile()
    {
        return $this->backgroundFile;
    }

    public function setBackgroundFile($backgroundFile): void
    {
        $this->backgroundFile = $backgroundFile;
    }

    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    public function setLogoUrl($logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    public function getBackgroundUrl()
    {
        return $this->backgroundUrl;
    }

    public function setBackgroundUrl($backgroundUrl): void
    {
        $this->backgroundUrl = $backgroundUrl;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}