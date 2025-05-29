<?php

namespace App\DTO\Orders;

class CheckoutDTO
{
    public function __construct(
        public string $fullName,
        public string $phone,
        public string $address,
        public ?string $deliveryTime,
        public ?string $notes,
        public string $paymentMethod,
        public bool $useBonuses,
        public array $cartItems,
        public bool $callback,
    )
    {
        
    }
}