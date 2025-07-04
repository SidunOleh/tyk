<?php

namespace App\DTO\Orders;

use App\DTO\BaseDTO;
use App\Http\Requests\Mobile\Order\CheckoutRequest;
use App\Http\Requests\Orders\CheckoutRequest as OrdersCheckoutRequest;
use App\Models\Order;

class CheckoutDTO extends BaseDTO
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
        public string $source
    )
    {
        
    }

    public static function createFromWebRequest(OrdersCheckoutRequest $request, array $cartItems): self
    {
        return new self(
            $request->full_name,
            $request->phone,
            $request->address,
            $request->delivery_time,
            $request->notes,
            $request->payment_method,
            $request->use_bonuses == 'on',
            $cartItems,
            $request->callback == 'on',
            Order::WEB
        );
    }

    public static function createFromMobileRequest(CheckoutRequest $request): self
    {
        return new self(
            $request->full_name,
            $request->phone,
            $request->address,
            $request->delivery_time,
            $request->notes,
            $request->payment_method,
            $request->use_bonuses,
            $request->cart_items,
            false,
            Order::MOBILE
        );
    }
}