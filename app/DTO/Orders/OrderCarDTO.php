<?php

namespace App\DTO\Orders;

use App\DTO\BaseDTO;
use App\Http\Requests\Mobile\Order\OrderCarRequest;
use App\Http\Requests\Orders\OrderCarRequest as OrdersOrderCarRequest;
use App\Models\Order;

class OrderCarDTO extends BaseDTO
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
        public bool $useBonuses,
        public bool $callback,
        public string $source
    )
    {
        
    }

    public static function createFromWebRequest(OrdersOrderCarRequest $request): self
    {
        return new self(
            $request->service,
            $request->from,
            $request->to,
            $request->date,
            $request->time,
            $request->shipping_type,
            $request->comment,
            $request->payment_method,
            $request->use_bonuses,
            $request->callback,
            Order::WEB
        );
    }

    public static function createFromMobileRequest(OrderCarRequest $request): self
    {
        return new self(
            $request->service,
            $request->from,
            $request->to,
            $request->date,
            $request->time,
            $request->shipping_type,
            $request->comment,
            $request->payment_method,
            $request->use_bonuses,
            false,
            Order::MOBILE
        );
    }
}