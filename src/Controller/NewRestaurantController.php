<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\NewRestaurantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewRestaurantController extends AbstractController
{
    #[Route('/new-restaurant')]
    public function createNewRestaurant(Request $request, ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();

        $form = $this->createForm(NewRestaurantType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = new Restaurant();

            $data = $form->getData();
            $logoFile = $form['logo_url']->getData();
            $backgroundFile = $form['background_url']->getData();

            $restaurant->setName($data["restaurant_name"]);
            $restaurant->setShopUrl($data["shop_url"]);
            $restaurant->setLogoFile($data["logo_url"]);
            $restaurant->setBackgroundFile($data["background_url"]);
            $restaurant->setBackgroundUrl("test");

            $path = 'assets/img/restaurants/';
            $logoFileName = 'logo ' . $data["restaurant_name"] . "." . $logoFile->guessExtension();
            $backgroundFileName = 'background ' . $data["restaurant_name"] . "." . $backgroundFile->guessExtension();

            $restaurant->setLogoUrl($path . $logoFileName);
            $restaurant->setBackgroundUrl($path . $backgroundFileName);


            $logoFile->move($path, $logoFileName);
            $backgroundFile->move($path, $backgroundFileName);

            $manager->persist($restaurant);
            $manager->flush();
        }

        return $this->renderForm('new_restaurant.html.twig', [
            'form' => $form
        ]);
    }
}