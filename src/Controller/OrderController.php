<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\ImportType;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use App\Service\ChartService;
use App\Service\DeliveryTimeService;
use App\Service\ScoreService;
use Carbon\Carbon;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class OrderController extends AbstractController
{
    #[Route('/orders', name: 'orders')]
    public function OrderIndex(
        Request      $request, ManagerRegistry $doctrine, ScoreService $score, ChartBuilderInterface $chartBuilder,
        ChartService $charts, OrderRepository $orderRepository, DeliveryTimeService $timeService
    ): Response
    {
        $manager = $doctrine->getManager();
        $last13WeeksSpendatureChart = null;

        // GET ENTITIES
        $orders = $doctrine->getRepository(Order::class)->findAll();
        if (!$orders)
            $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        else
            $restaurants = $doctrine->getRepository(Restaurant::class)->getAllRestaurantsWithScore($doctrine);

        // DELIVERY TIME
        $times = [];
        foreach ($orders as $order)
            $times[$order->getRestaurant()->getName()] = $timeService->calculateDuration($order->getOrderTime(), $order->getDeliveryTime());

        // CHARTS
        if ($restaurants && $orders)
            $last13WeeksSpendatureChart = $charts->createChartSpendatureLast13Weeks($doctrine, $chartBuilder, $orderRepository);

        //FORM
        $form = $this->createForm(OrderType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order = new Order();

            $data = $form->getData();

            $order->setRestaurant($data["restaurants"]);
            $order->setOrderTime(Carbon::createFromFormat('d.m H:i', $data["order_time"]));
            $order->setDeliveryTime(Carbon::createFromFormat('d.m H:i', $data["delivery_time"]));
            $order->setTotalPrice($data["total_price"]);
            $order->setTotalItems($data["total_items"]);
            $order->setFaulty($data["faulty"]);
            $order->setBonus($data["bonus"]);
            $order->setDriverNeededHelp($data["driver_needed_help"]);
            $order->setScore(
                $score->setScore($data, true)
            );

            $manager->persist($order);
            $manager->flush();

            return $this->redirectToRoute('new-order');
        }

        return $this->renderForm('order_index.html.twig', [
            'form' => $form,
            'orders' => $orders,
            'times' => $times,
            'chart_spent_last_13_weeks' => $last13WeeksSpendatureChart,
        ]);
    }

    #[Route('/new-order', name: 'new-order')]
    public function createNewOrder(Request $request, ManagerRegistry $doctrine, ScoreService $score): Response
    {
        $manager = $doctrine->getManager();

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order->setScore(
                $score->setScore($order, true)
            );

            $manager->persist($order);
            $manager->flush();

            return $this->redirectToRoute('new-order');
        }

        return $this->renderForm('new_order.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
        ]);
    }

    #[Route('/edit-order/{order}', name:'edit_order')]
    public function editOrder(Request $request, Order $order,ManagerRegistry $doctrine, ScoreService $score): Response
    {
        $manager = $doctrine->getManager();

        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order->setScore(
                $score->setScore($order, false)
            );
            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute('index');
        }

        return $this->renderForm('edit_order.html.twig', [
            'form' => $form,
            'order' => $order,
        ]);
    }

    #[Route(path: '/import', name: 'import')]
    public function import(Request $request, OrderRepository $orderRepository, RestaurantRepository $restaurantRepository): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->add('upload', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $csv */
            $csv = $form->get('csv')->getData();
            $csvArray = explode("\n", $csv->getContent());
            $restaurants = $restaurantRepository->findBy([], [], 10);
            foreach ($csvArray as $orderItems) {
                $randomKey = array_rand($restaurants);
                [
                    $id,
                    $restaurantName,
                    $totalPrice,
                    $orderTime,
                    $deliveryTime
                ] = explode(',', $orderItems);

                $order = new Order();
                $order->setId($id);
                $order->setRestaurant($restaurants[$randomKey]);
                $order->setTotalPrice($totalPrice);
                $order->setOrderTime(Carbon::createFromFormat('Y-m-d H:i:s',$orderTime));
                $order->setDeliveryTime(Carbon::createFromFormat('Y-m-d H:i:s',$deliveryTime));
                $order->setTotalItems(110);
                $order->setFaulty(false);
                $order->setBonus(false);
                $order->setDriverNeededHelp(false);

                $orderRepository->save($order);
            }

            $orderRepository->flush();
            $this->addFlash('success', 'Import csv with orders successfully');
            return $this->redirectToRoute('orders');
        }

        $response = new Response(null, $form->isSubmitted() ? 422 : 200);

        return $this->render('import.html.twig', [
            'form' => $form->createView(),
        ], $response);
    }
}