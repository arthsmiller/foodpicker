<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
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
                    'label' => 'Pricy',
                    'backgroundColor' => 'rgba(255, 99, 132, .5)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'fill' => true,
                    'tension' => .4,
                    'borderWidth' => 3,
                    'data' => $ordersLast8Weeks['values'],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => min($ordersLast8Weeks['values']) * .95,
                'suggestedMax' => max($ordersLast8Weeks['values']) * 1.05,
                ],
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

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        foreach ($restaurants as $restaurantKey => $restaurant){
            $result['restaurant_name'][$restaurantKey] = $restaurant->getName();
            $result['values'][$restaurantKey] = 0;

            foreach ($orders as $orderKey => $order){
                if ($restaurant->getName() === $order->getRestaurant()->getName()){
                    $result['values'][$restaurantKey] += ($order->getTotalPrice() / 100);
                }
            }
        }

        $chart->setData([
            'labels' => $result['restaurant_name'],
            'datasets' => [
                [
                    'label' => 'Pricy',
                'backgroundColor' => 'rgba(255, 99, 132, .5)',
                'borderColor' => 'rgb(255, 99, 132)',
                'borderWidth' => 3,
                'borderRadius' => 14,
                'data' => $result['values'],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => min($result['values']) * .95,
                'suggestedMax' => max($result['values']) * 1.05,
                ],
            ],
        ]);

        return $chart;
    }
}