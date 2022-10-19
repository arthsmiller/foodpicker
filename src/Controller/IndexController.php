<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use App\Service\ChartService;
use App\Service\RestaurantPickerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request $request, ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder, ChartService $charts, RestaurantPickerService $pickerService,
        OrderRepository $orderRepository, RestaurantRepository $restaurantRepository
    ): Response
    {
        //$manager = $doctrine->getManager();
        $last8WeeksSpendatureChart = null;
        $restaurantsSpendatureChart = null;
        $randomRestaurant = null;
        $coupons = null;

        $orders = $doctrine->getRepository(Order::class)->findAll();

        if (!$orders) $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        else {
            $restaurants = $doctrine->getRepository(Restaurant::class)->getAllRestaurantsWithScore($doctrine);
        }

        if ($restaurants && $orders){
            $coupons = $doctrine->getRepository(Coupon::class)->findAll();
            $last8WeeksSpendatureChart  = $charts->createChartSpendatureLast13Weeks($doctrine, $chartBuilder, $orderRepository);
            $restaurantsSpendatureChart = $charts->createChartSpendaturePerRestaurant($doctrine, $chartBuilder, $restaurantRepository, $orderRepository);
            $randomRestaurant           = $pickerService->getRandomWeightedRestaurant($doctrine, $restaurantRepository);
        }

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
            'random_restaurant' => $randomRestaurant,
        ]);
    }
}

/**
 *  PLAN FOR STATISTIC: TOTAL MONEY SPENT PER WEEK
 *  last 8 months
 *  besides that, spendature this week in bold and big
 *
 */