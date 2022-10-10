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

    #[Route('/edit-coupon/{id}', name:'edit_coupon')]
    public function editCoupon(Request $request, ManagerRegistry $doctrine, string $id): Response
    {
        $manager = $doctrine->getManager();

        $form = $this->createForm(NewCouponType::class);

        $coupon = $manager->getRepository(Coupon::class)->find($id);

        $form->get('restaurants')->setData($coupon->getRestaurant());
        $form->get('receive_time')->setData($coupon->getReceiveDate());
        $form->get('expiration_time')->setData($coupon->getExpirationDate());
        $form->get('amount')->setData($coupon->getAmount());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $coupon->setRestaurant($data["restaurants"]);
            $coupon->setReceiveDate(Carbon::createFromFormat('Y-m-d H:i:s', $data["receive_time"]));
            $coupon->setExpirationDate(Carbon::createFromFormat('Y-m-d H:i:s', $data["expiration_time"]));
            $coupon->setAmount($data["amount"]);
            $coupon->setRedeemed(false);

            $manager->persist($coupon);
            $manager->flush();
        }

        return $this->renderForm('edit_coupon.html.twig', [
            'form' => $form,
            'coupon' => $coupon,
        ]);
    }
}