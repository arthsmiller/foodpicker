<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function getAllRestaurants(): array
    {
        $manager = $this->getEntityManager();

        $query = $manager->createQuery(
            'SELECT * FROM App\Entity\Restaurant'
        );

        return $query->getArrayResult();
    }
}