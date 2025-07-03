<?php

namespace App\DTO\WorkShifts;

use App\DTO\BaseDTO;

class StatDTO extends BaseDTO
{
    public function __construct(
        public int $foodShippingCount = 0,
        public float $foodShippingTotal = 0,
        public float $foodShippingBonuses = 0,
        public int $shippingCount = 0,
        public float $shippingTotal = 0,
        public float $shippingBonuses = 0,
        public int $taxiCount = 0,
        public float $taxiTotal = 0,
        public float $taxiBonuses = 0
    )
    {
        
    }
}