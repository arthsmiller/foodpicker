<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportManager
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected RestaurantRepository $restaurantRepository
    )
    {
    }

    public function import(UploadedFile $csv): void
    {
        $csvData = explode("\n", $csv->getContent());
        foreach ($csvData as $orderItems) {
            $orderData = explode(',', $orderItems);

            if (count($orderData) !== 9) {
                throw new \Exception("Data in the CSVs is wrong!");
            }

            [
                $id,
                $restaurantName,
                $totalPrice,
                $orderTime,
                $deliveryTime,
                $totalItems,
                $faulty,
                $bonus,
                $needHelp
            ] = $orderData;

            try {
                $restaurant = $this->restaurantRepository->findByName($restaurantName);
            } catch (\Exception) {
                continue;
            }

            $order = new Order();
            $order->setId($id);
            $order->setRestaurant($restaurant);
            $order->setTotalPrice($totalPrice);
            $order->setOrderTime(Carbon::createFromFormat('Y-m-d H:i:s', $orderTime));
            $order->setDeliveryTime(Carbon::createFromFormat('Y-m-d H:i:s', $deliveryTime));
            $order->setTotalItems($totalItems);
            $order->setFaulty($faulty);
            $order->setBonus($bonus);
            $order->setDriverNeededHelp($needHelp);

            $this->orderRepository->save($order);
        }
        $this->orderRepository->flush();
    }
}