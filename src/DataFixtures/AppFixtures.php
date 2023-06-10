<?php

namespace App\DataFixtures;

use App\Factory\OrderFactory;
use App\Factory\RestaurantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        RestaurantFactory::createMany(10);
        OrderFactory::createMany(5, [
            'restaurant' => RestaurantFactory::random()
        ]);

    }
}
