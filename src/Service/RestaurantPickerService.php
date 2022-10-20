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

    public function getRandomWeightedRestaurant(ManagerRegistry $doctrine, RestaurantRepository $restaurantRepository): ?Object
    {
        $restaurants = $restaurantRepository->getAllRestaurantsWithScore($doctrine);

        $scores = [];
        $randomScore = [];

        foreach ($restaurants as $restaurant){
            $scores[$restaurant->getId()] = $restaurant->score;
        }

        foreach ($restaurants as $restaurant){
            $randomScore[$restaurant->getId()]  = $scores[$restaurant->getId()];
            $randomScore[$restaurant->getId()] += rand(max($scores) * .3, max($scores) * 2);
        }

//        foreach ($randomScore as $r){var_dump($r);}

        $maxScore = max($randomScore);

        foreach ($restaurants as $restaurant){
            if ($maxScore == $randomScore[$restaurant->getId()]) return $restaurant;
        }

        return null;
    }
}