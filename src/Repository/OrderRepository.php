<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Restaurant;
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

    public function save(Order $order, bool $flush = true): void
    {
        $this->getEntityManager()->persist($order);
        if($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }

    public function getEachWeeksSpendatureLast13Weeks(ManagerRegistry $doctrine): array
    {

        $minus8Weeks = CarbonImmutable::now()->subtract(12, 'weeks');
        $orders = $doctrine->getRepository(Order::class)->findAll();
        $result = [];

        for ($i = 0 ; $i < 13 ; ++$i){
            $result['weeks'][$i] = $minus8Weeks->add($i, 'weeks')->weekOfYear;
            $result['values'][$i] = 0;

            foreach ($orders as $order){
                $orderWeek = $order->getOrderTime()->weekOfYear;

                if($orderWeek === $result['weeks'][$i]){
                    $result['values'][$i] += ($order->getTotalPrice() / 100);
                }
            }
        }

        return $result;
    }


}