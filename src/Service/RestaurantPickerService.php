<?php

namespace App\Service;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;

class RestaurantPickerService
{
    /**
     *  @TODO: PLAN:
     *  Randomized pick of a restaurant
     *  each restaurant will get a random number, a score
     *  The range of the score will be derived from the range of scores that the restaurants already have
     *  maybe like 200% of the highest score, minumum 50% (needs testing for proofing if the range makes sense)
     *  after a random score has been generated for each restaurant, the existing score will be added to each
     *  result: a randomized number, weighted with popularity
     */

    public function getRandomWeightedRestaurant(ManagerRegistry $doctrine, RestaurantRepository $restaurantRepository)
    {
        $restaurants = $restaurantRepository->findAll();

        $scores = [];
        $result = [];
        $luckyRestaurant = null;

        foreach ($restaurants as $key => $restaurant){
            $scores[$restaurant->getId()] = $restaurant->getScore();
        }

        foreach ($restaurants as $key => $restaurant){
            $result[$restaurant->getId()]  = $scores[$restaurant->getId()];
            $result[$restaurant->getId()] += rand(max($scores) * .3, max($scores) * 2);
        }

        foreach ($result as $r){var_dump($r);}

        $maxScore = max($result);

        foreach ($restaurants as $key => $restaurant){
            if ($maxScore == $result[$restaurant->getId()]) $luckyRestaurant = $restaurantRepository->findById($restaurant->getId());
        }

        return $luckyRestaurant[0];
    }
}