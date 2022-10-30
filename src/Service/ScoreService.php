<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Restaurant;
use Carbon\Carbon;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ScoreService
{
    public const BASE_SCORE = 10;
    public const DELIVERY_BEFORE_12 = 3;
    public const DELIVERY_OVER_1_HOUR = -1;
    public const DELIVERY_OVER_1_5_HOURS = -2;
    public const BONUS = 3;
    public const FAULTY = -3;
    public const DRIVER_NEEDED_HELP = -2;

    public function setScore($formData, bool $isNew): int
    {
        $score = 0;

        // The if is needed bc i dont want to write the year when adding a new order
        if ($isNew){
            $orderTime = Carbon::createFromFormat('d.m H:i', $formData['order_time']);
            $deliveryTime = Carbon::createFromFormat('d.m H:i', $formData['delivery_time']);
        } else{
            $orderTime = Carbon::createFromFormat('Y-m-d H:i:s', $formData['order_time']);
            $deliveryTime = Carbon::createFromFormat('Y-m-d H:i:s', $formData['delivery_time']);
        }

        $score = self::BASE_SCORE;
        $score += $this->checkDeliveryBefore12(Carbon::create($deliveryTime));
        //$score += $this->checkDeliveryLessThan1h(Carbon::create($orderTime), Carbon::create($deliveryTime));
        $score += $this->checkDeliveryLessThan1_5h(Carbon::create($orderTime), Carbon::create($deliveryTime));
        $score += $this->checkBonus($formData['bonus']);
        $score += $this->checkFaulty($formData['faulty']);
        $score += $this->checkDriverHelp($formData['driver_needed_help']);

        return $score;
    }

    public function getScore($orderTime, $deliveryTime, $faulty, $bonus, $driverNeededHelp)
    {
        $score = self::BASE_SCORE;
        $score += $this->checkDeliveryBefore12(Carbon::create($deliveryTime));
        $score += $this->checkDeliveryLessThan1h(Carbon::create($orderTime),Carbon::create($deliveryTime));
        $score += $this->checkDeliveryLessThan1_5h(Carbon::create($orderTime), Carbon::create($deliveryTime));
        $score += $this->checkBonus($bonus);
        $score += $this->checkFaulty($faulty);
        $score += $this->checkDriverHelp($driverNeededHelp);

        return $score;
    }

    protected function checkDeliveryBefore12(Carbon $deliveryTime): int
    {
        if ($deliveryTime->greaterThan(Carbon::create($deliveryTime)->hour(12)->minute(0)))
            return 0;

        return self::DELIVERY_BEFORE_12;
    }

    protected function checkDeliveryLessThan1h(Carbon $orderTime, Carbon $deliveryTime): int
    {
        if ($orderTime->addHour()->greaterThan($deliveryTime))
            return 0;

        return self::DELIVERY_OVER_1_HOUR;
    }

    protected function checkDeliveryLessThan1_5h(Carbon $orderTime, Carbon $deliveryTime): int
    {
        if ($orderTime->addHour()->addMinutes(30)->greaterThan($deliveryTime))
            return 0;

        return self::DELIVERY_OVER_1_5_HOURS;
    }

    protected function checkBonus(bool $bonus)
    {
        if (!$bonus)
            return 0;

        return self::BONUS;
    }

    protected function checkFaulty(bool $faulty)
    {
        if (!$faulty)
            return 0;

        return self::FAULTY;
    }

    protected function checkDriverHelp(bool $help)
    {
        if (!$help)
            return 0;

        return self::DRIVER_NEEDED_HELP;
    }
}