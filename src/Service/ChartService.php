<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Color;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartService
{
    public function createChartSpendatureLast13Weeks(
        ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder, OrderRepository $orderRepository
    ): Chart
    {
        $ordersLast8Weeks = $orderRepository->getEachWeeksSpendatureLast13Weeks($doctrine);

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $ordersLast8Weeks['weeks'],
            'datasets' => [
                [
                    'label' => '€ per week',
                    'backgroundColor' => 'rgba(255, 99, 132, .5)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'fill' => true,
                    'tension' => .4,
                    'borderWidth' => 3,
                    'data' => $ordersLast8Weeks['values'],
                    'pointRadius' => 2,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => min($ordersLast8Weeks['values']) * .95,
                    'suggestedMax' => max($ordersLast8Weeks['values']) * 1.05,
                    'grid' => ['display'=> false]
                ],
                'x' => [
                    'ticks' => ['display'=> false],
                    'grid' => ['display'=> false]
                ]
            ],
        ]);

        return $chart;
    }

    public function createChartSpendaturePerRestaurant(
        ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder, RestaurantRepository $restaurantRepository, OrderRepository $orderRepository
    ): Chart
    {
        $restaurants = $restaurantRepository->findAll();
        $orders = $orderRepository->findAll();
        $result = [];

        foreach ($restaurants as $restaurantKey => $restaurant){
            $result[$restaurant->getName()] = 0;

            foreach ($orders as $order){
                if ($restaurant->getName() === $order->getRestaurant()->getName()){
                    $result[$restaurant->getName()] += ($order->getTotalPrice() / 100);
                }
            }
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        arsort($result);

        $chart->setData([
            'labels' => array_keys($result),
            'datasets' => [
                [
                    'label' => '€ per restaurant',
                'backgroundColor' => 'rgba(255, 99, 132, .5)',
                'borderColor' => 'rgb(255, 99, 132)',
                'borderWidth' => 3,
                'borderRadius' => 8,
                'data' => $result
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => min($result) * .95,
                    'suggestedMax' => max($result) * 1.05,
                    'grid' => ['display'=> false]
                ],
                'x' => [
                    'ticks' => ['display'=> false],
                    'grid' => ['display'=> false]
                ]
            ],
        ]);

        return $chart;
    }
}