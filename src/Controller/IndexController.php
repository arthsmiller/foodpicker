<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\RandomRestaurantType;
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
        Request                 $request, ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder, ChartService $charts,
        RestaurantPickerService $pickerService, OrderRepository $orderRepository,
        RestaurantRepository    $restaurantRepository, RandomRestaurantType $randomType
    ): Response
    {
        $last13WeeksSpendatureChart = null;
        $restaurantsSpendatureChart = null;
        $randomRestaurant = null;
        $coupons = null;

        $orders = $doctrine->getRepository(Order::class)->findAll();

        if (!$orders) $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        else {
            $restaurants = $doctrine->getRepository(Restaurant::class)->getAllRestaurantsWithScore($doctrine);
        }

        if ($restaurants && $orders) {
            $randomRestaurant = $pickerService->getRandomWeightedRestaurant($doctrine, $restaurantRepository);
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
                if ($restaurant->getName() == $order->getRestaurant()->getName()) {
                    $moneySpent[$restaurant->getName()] = $moneySpent[$restaurant->getName()] + $order->getTotalPrice();
                }
            }
        }

        $randomRestaurantButton = $this->createForm(RandomRestaurantType::class);
        $randomRestaurantButton->handleRequest($request);

        if ($randomRestaurantButton->isSubmitted() && $randomRestaurantButton->isValid())
            return $this->redirectToRoute('index');

        return $this->render('index.html.twig',
            [
                'restaurants' => $restaurants,
                'random_restaurant' => $randomRestaurant,
                'random_restaurant_button' => $randomRestaurantButton,
            ]);
    }

    #[Route(path: '/export', name: 'export')]
    public function export(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        $rows = [];
        /** @var Order $order */
        foreach ($orders as $order) {
            $rows[] = implode(',', [
                $order->getId(),
                $order->getRestaurant()->getName(),
                $order->getTotalPrice(),
                $order->getOrderTime()->format('Y-m-d H:i:s'),
                $order->getDeliveryTime()->format('Y-m-d H:i:s'),
                $order->getTotalItems(),
                (int)$order->getFaulty(),
                (int)$order->getBonus(),
                (int)$order->getDriverNeededHelp(),
            ]);
        }
        $content = implode("\n", $rows);

        return new Response($content, 200, ['Content-Type' => 'text/csv']);
    }
}