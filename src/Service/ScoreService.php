<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Restaurant;
use Carbon\Carbon;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ScoreService
{
    public const BASE_SCORE = 10;
    public const DELIVERY_BEFORE_12 = 5;
    public const DELIVERY_OVER_1_HOUR = -2;
    public const DELIVERY_OVER_1_5_HOURS = -3;
    public const BONUS = 3;
    public const FAULTY = -3;
    public const DRIVER_NEEDED_HELP = -2;

    public function setScore(Order $order, $formData, ManagerRegistry $doctrine)
    {
        $manager = $doctrine->getManager();

        $restaurant = $manager->find(Restaurant::class, $formData['restaurants']);

        $orderTime = Carbon::create($formData['order_time']);
        $deliveryTime = Carbon::create($formData['delivery_time']);

        $score = self::BASE_SCORE;
        $score += $this->checkDeliveryBefore12($deliveryTime);
        $score += $this->checkDeliveryLessThan1h($orderTime, $deliveryTime);
        $score += $this->checkDeliveryLessThan1_5h($orderTime, $deliveryTime);
        $score += $this->checkBonus($formData['bonus']);
        $score += $this->checkFaulty($formData['bonus']);
//        $score += $this->checkDriverHelp($formData['help']);
        if (isset($formData['score'])) $score += $formData['score'];

        $restaurant->setScore($score);

        $manager->persist($restaurant);
        $manager->flush();
    }

    protected function checkDeliveryBefore12(Carbon $deliveryTime): int
    {
        $twelveOClock = Carbon::createFromTime(12);

        if ($deliveryTime->greaterThan($twelveOClock)) return 0;

        return self::DELIVERY_BEFORE_12;
    }

    protected function checkDeliveryLessThan1h(Carbon $orderTime, Carbon $deliveryTime): int
    {
        if ($orderTime->addHour()->lessThan($deliveryTime)) return 0;

        return self::DELIVERY_OVER_1_HOUR;
    }

    protected function checkDeliveryLessThan1_5h(Carbon $orderTime, Carbon $deliveryTime): int
    {
        if ($orderTime->addHour()->addMinutes(30)->lessThan($deliveryTime)) return 0;

        return self::DELIVERY_OVER_1_5_HOURS;
    }

    protected function checkBonus(bool $bonus)
    {
        if (!$bonus) return 0;

        return self::BONUS;
    }

    protected function checkFaulty(bool $faulty)
    {
        if (!$faulty) return 0;

        return self::FAULTY;
    }

    protected function checkDriverHelp(bool $help)
    {
        if (!$help) return 0;

        return self::DRIVER_NEEDED_HELP;
    }
}