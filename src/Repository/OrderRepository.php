<?php

namespace App\Repository;

use App\Entity\Order;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Order::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }

    public function getEachWeeksSpendatureLast8Weeks(ManagerRegistry $doctrine): array
    {
        $currentWeek = Carbon::now()->subtract(8, 'weeks');
        $minus8Weeks = CarbonImmutable::now()->subtract(7, 'weeks');
        $orders = $doctrine->getRepository(Order::class)->findAll();
        $result = [];

        for ($i = 0 ; $i < 8 ; ++$i){
            $result['weeks'][$i] = $minus8Weeks->add($i, 'weeks')->weekOfYear;
            $result['values'][$i] = 0;

            foreach ($orders as $key => $order){
                $orderWeek = $order->getOrderTime()->weekOfYear;

                if($orderWeek === $result['weeks'][$i]){
                    $result['values'][$i] += ($order->getTotalPrice() / 100);
                }
            }
        }

        return $result;
    }
}