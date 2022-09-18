<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Restaurant;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();

        $moneySpent = [];

        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        $orders = $doctrine->getRepository(Order::class)->findAll();

        return $this->render('index.html.twig',
        [
            'restaurants' => $restaurants,
            'orders' => $orders,
        ]);
    }
}