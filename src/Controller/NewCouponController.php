<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\NewOrderType;
use Carbon\Carbon;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewCouponController extends AbstractController
{
    #[Route('/new-counpon')]
    public function createNewCoupon(Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();

        $form = $this->createForm(NewOrderType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $coupon = new Coupon();

            $data = $form->getData();
            $coupon->setRestaurant($data["restaurant"]);
            $coupon->setOrderTime(Carbon::createFromFormat('H:i', $data["order_time"]));
            $coupon->setDeliveryTime(Carbon::createFromFormat('H:i', $data["delivery_time"]));
            $coupon->setTotalPrice($data["total_price"]);
            $coupon->setTotalPersons($data["total_persons"]);
            $coupon->setTotalItems($data["total_items"]);
            $coupon->setFaulty($data["faulty"]);
            $coupon->setBonus($data["bonus"]);

            $manager->persist($coupon);
            $manager->flush();
        }

        return $this->renderForm('new_order.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
        ]);
    }
}