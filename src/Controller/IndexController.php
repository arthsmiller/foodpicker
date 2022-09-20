<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Order;
use App\Entity\Restaurant;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $orders = $doctrine->getRepository(Order::class)->findAll();
        $coupons = $doctrine->getRepository(Coupon::class)->findAll();

        // define each restaurant for calculations
        if ($restaurants == NULL) $moneySpent = 0;
        foreach ($restaurants as $restaurant) {
            $moneySpent[$restaurant->getName()] = 0;
        }

        // calculate sum of orders for each restaurant
        foreach ($orders as $order) {
            foreach ($restaurants as $restaurant) {
                if ($restaurant->getName() == $order->getRestaurant()->getName()){
                    $moneySpent[$restaurant->getName()] = $moneySpent[$restaurant->getName()] + $order->getTotalPrice();
                }
            }
        }

        return $this->render('index.html.twig',
        [
            'restaurants' => $restaurants,
            'orders' => $orders,
            'coupons' => $coupons,
            'money_spent' => $moneySpent,
        ]);
    }
}