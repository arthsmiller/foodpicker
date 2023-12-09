<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\ImportType;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Service\ChartService;
use App\Service\DeliveryTimeService;
use App\Service\ImportManager;
use App\Service\ScoreService;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class OrderController extends AbstractController
{
    #[Route('/orders', name: 'orders')]
    public function OrderIndex(
        Request         $request,
        ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder,
        ChartService    $charts, OrderRepository $orderRepository, DeliveryTimeService $timeService, PaginatorInterface $paginator
    ): Response
    {
        $last13WeeksSpendatureChart = null;

        // GET ENTITIES
        $orders = $orderRepository->qbFindAll();

        $pagination = $paginator->paginate(
            $orders, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        $orders = $orders->getQuery()->getResult();
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

        return $this->render('order_index.html.twig', [
            'pagination' => $pagination,
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

        return $this->render('new_order.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
        ]);
    }

    #[Route('/edit-order/{order}', name: 'edit_order')]
    public function editOrder(Request $request, Order $order, ManagerRegistry $doctrine, ScoreService $score): Response
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

        return $this->render('edit_order.html.twig', [
            'form' => $form,
            'order' => $order,
        ]);
    }

    #[Route(path: '/import', name: 'import')]
    public function import(Request $request, ImportManager $importManager): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->add('upload', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $csv = $form->get('csv')->getData();
                $importManager->import($csv);
                $this->addFlash('success', 'Import csv with orders successfully');
            } catch (\Exception $exception) {
                $this->addFlash('warning', $exception->getMessage());
                return $this->redirectToRoute('import');
            }
            return $this->redirectToRoute('orders');
        }

        $response = new Response(null, $form->isSubmitted() ? 422 : 200);

        return $this->render('import.html.twig', [
            'form' => $form->createView(),
        ], $response);
    }
}