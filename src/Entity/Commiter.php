<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'commiters')]
class Commiter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected $id;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: Commiter::class)]
    protected ?Collection $orders;

    #[ORM\Column(type: Types::STRING)]
    protected $userName;

    #[ORM\Column(type: Types::STRING)]
    protected $password;

    #[ORM\Column(type: Types::STRING)]
    protected $userProfilePictureUrl;

    #[ORM\Column(type: Types::BOOLEAN)]
    protected $banned; // FOR 3 TIMES FAILED

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

    public function getOrders(): ArrayCollection|Collection|null
    {
        return $this->orders;
    }

    public function setOrders(ArrayCollection|Collection|null $orders): void
    {
        $this->orders = $orders;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getUserProfilePictureUrl()
    {
        return $this->userProfilePictureUrl;
    }

    public function setUserProfilePictureUrl($userProfilePictureUrl): void
    {
        $this->userProfilePictureUrl = $userProfilePictureUrl;
    }

    public function getBanned()
    {
        return $this->banned;
    }

    public function setBanned($banned): void
    {
        $this->banned = $banned;
    }


}