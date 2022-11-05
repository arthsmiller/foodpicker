<?php

namespace App\Service;

use Carbon\Carbon;

class DeliveryTimeService
{
    public function calculateDuration(Carbon $orderTime, Carbon $deliveryTime): String
    {
        return $orderTime->diffInMinutes($deliveryTime);
    }
}