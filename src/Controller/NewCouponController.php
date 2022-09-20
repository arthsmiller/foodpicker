<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\Restaurant;
use App\Form\NewCouponType;
use Carbon\Carbon;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewCouponController extends AbstractController
{
    #[Route('/new-coupon')]
    public function createNewCoupon(Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();

        $form = $this->createForm(NewCouponType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $coupon = new Coupon();

            $data = $form->getData();
            $coupon->setRestaurant($data["restaurants"]);
            $coupon->setReceiveDate(Carbon::createFromFormat('H:i', $data["receive_time"]));
            $coupon->setExpirationDate(Carbon::createFromFormat('H:i', $data["expiration_time"]));
            $coupon->setAmount($data["amount"]);
            $coupon->setRedeemed(false);

            $manager->persist($coupon);
            $manager->flush();
        }

        return $this->renderForm('new_coupon.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
        ]);
    }
}