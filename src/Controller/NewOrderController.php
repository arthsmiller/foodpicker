<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\NewOrderType;
use App\Service\ScoreService;
use Carbon\Carbon;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewOrderController extends AbstractController
{
    #[Route('/new-order')]
    public function createNewOrder(Request $request, ManagerRegistry $doctrine, ScoreService $score): Response
    {
        $manager = $doctrine->getManager();

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();

        $form = $this->createForm(NewOrderType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order = new Order();

            $data = $form->getData();

            $order->setRestaurant($data["restaurants"]);
            $order->setOrderTime(Carbon::createFromFormat('d.m H:i', $data["order_time"]));
            $order->setDeliveryTime(Carbon::createFromFormat('d.m H:i', $data["delivery_time"]));
            $order->setTotalPrice($data["total_price"]);
            $order->setTotalPersons($data["total_persons"]);
            $order->setTotalItems($data["total_items"]);
            $order->setFaulty($data["faulty"]);
            $order->setBonus($data["bonus"]);
            $order->setDriverNeededHelp($data["driver_needed_help"]);
            $order->setScore(
                $score->setScore($data, true)
            );

            $manager->persist($order);
            $manager->flush();
        }

        return $this->renderForm('new_order.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
        ]);
    }

    #[Route('/edit-order/{id}', name:'edit_order')]
    public function editOrder(Request $request, ManagerRegistry $doctrine, ScoreService $score, string $id): Response
    {
        $manager = $doctrine->getManager();

        $form = $this->createForm(NewOrderType::class);

        $order = $manager->getRepository(Order::class)->find($id);

        $form->get('restaurants')->setData($order->getRestaurant());
        $form->get('order_time')->setData($order->getOrderTime());
        $form->get('delivery_time')->setData($order->getDeliveryTime());
        $form->get('total_price')->setData($order->getTotalPrice());
        $form->get('total_persons')->setData($order->getTotalPersons());
        $form->get('total_items')->setData($order->getTotalItems());
        $form->get('faulty')->setData($order->getFaulty());
        $form->get('bonus')->setData($order->getBonus());
        $form->get('driver_needed_help')->setData($order->getDriverNeededHelp());

        $oldScore = $score->getScore(
            $order->getOrderTime(),
            $order->getDeliveryTime(),
            $order->getFaulty(),
            $order->getBonus(),
            $order->getDriverNeededHelp(),
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $order->setRestaurant($data["restaurants"]);
            $order->setOrderTime(Carbon::createFromFormat('Y-m-d H:i:s', $data["order_time"]));
            $order->setDeliveryTime(Carbon::createFromFormat('Y-m-d H:i:s', $data["delivery_time"]));
            $order->setTotalPrice($data["total_price"]);
            $order->setTotalPersons($data["total_persons"]);
            $order->setTotalItems($data["total_items"]);
            $order->setFaulty($data["faulty"]);
            $order->setBonus($data["bonus"]);
            $order->setDriverNeededHelp($data["driver_needed_help"]);

            $order->setScore(
                $score->setScore($data, false)
            );

            $manager->persist($order);
            $manager->flush();
        }

        return $this->renderForm('edit_order.html.twig', [
            'form' => $form,
            'order' => $order,
        ]);
    }
}