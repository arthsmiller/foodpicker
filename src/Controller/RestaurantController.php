<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Restaurant;
use App\Form\EditRestaurantType;
use App\Form\NewRestaurantType;
use App\Form\RandomRestaurantType;
use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use App\Service\ChartService;
use App\Service\RestaurantPickerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class RestaurantController extends AbstractController
{
    #[Route('/restaurants', name:'restaurants')]
    public function restaurantIndex(
        Request $request, ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder, ChartService $charts,
        OrderRepository $orderRepository, RestaurantRepository $restaurantRepository
    ): Response
    {
        $manager = $doctrine->getManager();
        $restaurantsSpendatureChart = null;

        $orders = $doctrine->getRepository(Order::class)->findAll();

        if (!$orders)
            $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        else
            $restaurants = $doctrine->getRepository(Restaurant::class)->getAllRestaurantsWithScore($doctrine);

        if ($restaurants && $orders)
            $restaurantsSpendatureChart = $charts->createChartSpendaturePerRestaurant($doctrine, $chartBuilder, $restaurantRepository, $orderRepository);

        /* @TODO -> service */
        // define each restaurant for calculations
        if ($restaurants == NULL) $moneySpent = 0;
        foreach ($restaurants as $restaurant) {
            $moneySpent[$restaurant->getName()] = 0;
        }
        // calculate sum of orders for each restaurant
        foreach ($orders as $order) {
            foreach ($restaurants as $restaurant) {
                if ($restaurant->getName() == $order->getRestaurant()->getName()){
                    $moneySpent[$restaurant->getName()] = $moneySpent[$restaurant->getName()] + $order->getTotalPrice();
                }
            }
        }

        $form = $this->createForm(NewRestaurantType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = new Restaurant();

            $data = $form->getData();
            $logoFile = $form['logo_url']->getData();
            $backgroundFile = $form['background_url']->getData();

            $restaurant->setName($data["restaurant_name"]);
            $restaurant->setShopUrl($data["shop_url"]);
            $restaurant->setCategories(explode(", ", $data['categories']));
            $restaurant->setLogoFile($data["logo_url"]);
            $restaurant->setBackgroundFile($data["background_url"]);
            $restaurant->setBackgroundUrl("test");

            $logoFileName = 'logo ' . $data["restaurant_name"] . "." . $logoFile->guessExtension();
            $backgroundFileName = 'background ' . $data["restaurant_name"] . "." . $backgroundFile->guessExtension();
            $restaurant->setLogoUrl($restaurant::IMAGE_LOGO_PATH . $logoFileName);
            $restaurant->setBackgroundUrl($restaurant::IMAGE_BACKGROUND_PATH . $backgroundFileName);
            $logoFile->move($restaurant::IMAGE_LOGO_PATH, $logoFileName);
            $backgroundFile->move($restaurant::IMAGE_BACKGROUND_PATH, $backgroundFileName);

            $manager->persist($restaurant);
            $manager->flush();

            return $this->redirectToRoute('new-restaurant');
        }

        return $this->renderForm('restaurant_index.html.twig', [
            'form' => $form,
            'restaurants' => $restaurants,
            'money_spent' => $moneySpent,
            'restaurants_spendature_chart' => $restaurantsSpendatureChart,
        ]);
    }

    #[Route('/new-restaurant', name:'new-restaurant')]
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
            $restaurant->setCategories(explode(", ", $data['categories']));
            $restaurant->setLogoFile($data["logo_url"]);
            $restaurant->setBackgroundFile($data["background_url"]);
            $restaurant->setBackgroundUrl("test");

            $logoFileName = 'logo_' . $data["restaurant_name"] . "." . $logoFile->guessExtension();
            $backgroundFileName = 'background_' . $data["restaurant_name"] . "." . $backgroundFile->guessExtension();
            $restaurant->setLogoUrl($restaurant::IMAGE_LOGO_PATH . $logoFileName);
            $restaurant->setBackgroundUrl($restaurant::IMAGE_BACKGROUND_PATH . $backgroundFileName);
            $logoFile->move($restaurant::IMAGE_LOGO_PATH, $logoFileName);
            $backgroundFile->move($restaurant::IMAGE_BACKGROUND_PATH, $backgroundFileName);

            $manager->persist($restaurant);
            $manager->flush();

            return $this->redirectToRoute('new-restaurant');
        }

        return $this->renderForm('new_restaurant.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/edit-restaurant/{id}', name:'edit_restaurant')]
    public function editRestaurant(Request $request, ManagerRegistry $doctrine, string $id): Response
    {
        $manager = $doctrine->getManager();

        $form = $this->createForm(EditRestaurantType::class);

        $restaurant = $manager->getRepository(Restaurant::class)->find($id);

        $form->get('restaurant_name')->setData($restaurant->getName());
        $form->get('shop_url')->setData($restaurant->getShopUrl());
        $form->get('categories')->setData(implode(', ', $restaurant->getCategories()));



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $restaurant->setName($data["restaurant_name"]);
            $restaurant->setShopUrl($data["shop_url"]);
            $restaurant->setCategories(explode(", ", $data['categories']));


            $manager->persist($restaurant);
            $manager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->renderForm('edit_restaurant.html.twig', [
            'form' => $form,
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/restaurant/{id}')]
    public function viewRestaurant(ManagerRegistry $doctrine, int $id): Response
    {
        $restaurant = $doctrine->getRepository(Restaurant::class)->find($id);

        return $this->render('single_restaurant.html.twig', [
            'restaurant' => $restaurant
        ]);
    }
}