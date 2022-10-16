<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
#[ORM\Table(name: 'restaurants')]
class Restaurant
{
    public const IMAGE_PATH = 'assets/img/restaurants/';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: Restaurant::class)]
    protected ?Collection $orders;

    #[ORM\OneToMany(targetEntity: Coupon::class, mappedBy: Restaurant::class)]
    protected ?Collection $coupons;

    #[ORM\Column(type: Types::STRING)]
    protected string $name;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    protected $categories;

    #[ORM\Column(type: Types::STRING)]
    protected string $shopUrl;

    #[ORM\Column]
    protected $logoFile;

    #[ORM\Column(type: Types::STRING)]
    protected string $logoUrl;

    #[ORM\Column(nullable: true)]
    protected $backgroundFile;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected string $backgroundUrl;

    // temporary attribute
    public int $score = 0;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

    public function getShopUrl(): ?string
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

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl($logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    public function getBackgroundUrl(): ?string
    {
        return $this->backgroundUrl;
    }

    public function setBackgroundUrl($backgroundUrl): void
    {
        $this->backgroundUrl = $backgroundUrl;
    }
}