<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use App\Service\ChartService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class IndexController extends AbstractController
{
    #[Route('/')]
    public function index(
        Request $request, ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder, ChartService $charts,
        OrderRepository $orderRepository, RestaurantRepository $restaurantRepository
    ): Response
    {
        $manager = $doctrine->getManager();

        $last8WeeksSpendatureChart = $charts->createChartSpendatureLast8Weeks($doctrine, $chartBuilder, $orderRepository);
        $restaurantsSpendatureChart = $charts->createChartSpendaturePerRestaurant($doctrine, $chartBuilder, $restaurantRepository, $orderRepository);

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $orders = $doctrine->getRepository(Order::class)->findAll();
        $coupons = $doctrine->getRepository(Coupon::class)->findAll();

        /* @TODO -> service */
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
            'chart_spent_last_8_weeks' => $last8WeeksSpendatureChart,
            'chart_spent_per_restaurant' => $restaurantsSpendatureChart,
        ]);
    }
}

/**
 *  PLAN FOR STATISTIC: TOTAL MONEY SPENT PER WEEK
 *  last 8 months
 *  besides that, spendature this week in bold and big
 *
 */