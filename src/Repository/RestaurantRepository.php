<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Restaurant::class);
    }
/**
    public function findAll()
    {
        return $this->findBy(array(), array('score' => 'DESC'));
    }
*/
    public function getAllRestaurantsWithScore(ManagerRegistry $doctrine): array
    {
        $orders = $doctrine->getRepository(Order::class)->findAll();
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $scores = [];

        foreach ($orders as $order){
            $key = $order->getRestaurant()->getId();

            // if score is not initialized yet, set it to 0
            if (!isset($scores[$key])) $scores[$key] = 0;

            $scores[$key] += $order->getScore();
        }

        foreach ($restaurants as $restaurant){
            // if restaurant has no orders to count score, set to 0
            $restaurant->score = 0;

            // if it has orders, add the score
            if (isset($scores[$restaurant->getId()]))
                $restaurant->score = $scores[$restaurant->getId()];
        }

        return $restaurants;
    }

    public function findOneByName(String $restaurnatName){
        return $this->createQueryBuilder('r')
        ->andWhere('r.name = :val')
        ->setParameter('val', $restaurnatName)
        ->getQuery()
        ->getSingleResult()
        ;
    }
}