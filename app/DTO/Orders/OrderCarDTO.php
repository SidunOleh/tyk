<?php

namespace App\DTO\Orders;

class OrderCarDTO
{
    public function __construct(
        public string $service,
        public array $from,
        public array $to,
        public string $date,
        public string $time,
        public ?string $shippingType,
        public ?string $comment,
        public string $paymentMethod,
        public bool $useBonuses
    )
    {
        
    }
}