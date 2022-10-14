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
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class IndexController extends AbstractController
{
    #[Route('/')]
    public function index(
        Request $request, ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder
    ): Response
    {
        $manager = $doctrine->getManager();

         $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

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
            'chart' => $chart,
        ]);
    }
}