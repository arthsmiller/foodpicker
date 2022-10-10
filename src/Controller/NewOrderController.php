<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\NewOrderType;
use Carbon\Carbon;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewOrderController extends AbstractController
{
    #[Route('/new-order')]
    public function createNewOrder(Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();

        $form = $this->createForm(NewOrderType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order = new Order();

            $data = $form->getData();
            $order->setRestaurant($data["restaurants"]);
            $order->setOrderTime(Carbon::createFromFormat('H:i', $data["order_time"]));
            $order->setDeliveryTime(Carbon::createFromFormat('H:i', $data["delivery_time"]));
            $order->setTotalPrice($data["total_price"]);
            $order->setTotalPersons($data["total_persons"]);
            $order->setTotalItems($data["total_items"]);
            $order->setFaulty($data["faulty"]);
            $order->setBonus($data["bonus"]);

            $manager->persist($order);
            $manager->flush();
        }

        return $this->renderForm('new_order.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
        ]);
    }

}